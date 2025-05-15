<?php

namespace App\Repositories\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Interfaces\Blog\BlogRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Seo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Validator;
use DB;
use Gate;
use Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface {

  const CACHE_TTL = 86400; // 1 day

  public function index($request)
  {
    if ($request->ajax()) {
        if (Cache::has('Blog')){
            $query = Cache::get('Blog');
        } else {
            $query = Cache::remember('Blog', self::CACHE_TTL, function (){
                return Blog::all();
            });
        }
        $table = Datatables::of($query);
        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', 'მოქმედება');

        $table->editColumn('actions', function ($row) {
            $showGate      = 'backend.blogs.show';
            $editGate      = 'backend.blogs.edit';
            $destroyGate    = 'backend.blogs.destroy';
            $statusGate    = 'backend.blogs.status';

            return view('backend.partials.datatablesActions', compact(
                'statusGate',
                'showGate',
                'editGate',
                'destroyGate',
                'row'
            ));
        });

        $table->editColumn('id', function ($row) {
            return $row->id ? $row->id : "";
        });
        $table->editColumn('position', function ($row) {
            return $row->position ? $row->position : "";
        });
        $table->editColumn('title', function ($row) {
            return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
        });
        $table->editColumn('category', function ($row) {
            return view('backend.partials.datatablesCategory', compact(
                'row'
            ));
        });

        $table->editColumn('images', function ($row) {
            return view('backend.partials.datatablesImages', compact(
                'row'
            ));
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }

    return view('backend.blogs.index');
  }

  public function getlist()
  {
    if (Cache::has('Blog')){
      $blogs = Cache::get('Blog');
    } else {
      $blogs = Cache::remember('Blog', self::CACHE_TTL, function (){
          return Blog::all();
      });
    }

    return $blogs;
  }

  public function getSeoFirst($id)
  {
    $blog = Blog::find($id);
    return $blog->seo()->first();
  }

  public function status($request)
  {
    Cache::forget('Blog');
    $blog = Blog::find($request->model_id);
    $blog->status = $request->status;
    $blog->save();
    return response()->json(['success'=>'სტატუსი წარმატებით შეიცვალა!']);
  }

  public function create()
  {
    $blogCategories = BlogCategory::where('status','1')->where('parent_id', null)->orderBy('position','desc')->get();
    return $blogCategories;
  }

  public function store($request)
  {
    Cache::forget('Blog');

    $locales = getLocales();

    $valid = [
        'status' => 'required|integer',
    ];

    foreach ($locales as $loc) {
        if ($loc->status == 1) {
            $valid['title_' . $loc->code] = 'required|string';
        }
    }

    request()->validate($valid);

    $data = new Blog();
    foreach ($locales as $locale) {
        $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
        $data->setTranslation('content',$locale->code,$request->input('content_' . $locale->code));
        $data->setTranslation('slug',$locale->code,str::slug($request->input('title_' . $locale->code)));
    }
    $data->status = $request->status;
    $data->position = Blog::max('position') + 1;
    $data->save();
    if(!is_null($request->blogCategory)){
        $data->modelCategory()->attach($request->blogCategory);
    }
    if(!empty($request->input('seoTitles_' . app()->getLocale()))){
        $seo = new Seo;
        foreach ($locales as $locale) {
            $seo->setTranslation('seoTitles',$locale->code,$request->input('seoTitles_' . $locale->code));
            $seo->setTranslation('seoKeywords',$locale->code,$request->input('seoKeywords_' . $locale->code));
            $seo->setTranslation('seoDescriptions',$locale->code,$request->input('seoDescriptions_' . $locale->code));
        }
        $data->seo()->save($seo);
    }
    
    $images = [];
    if(@$request->images){
        $request->images = @$request->images ?: [];
        $mainImage_id = empty($request->mainImage_id) ? 0 : 1;
        foreach ($request->images as $key => $value){
          $images[$value]['ord'] = $key+1;
          $images[$value]['cover'] = $request->cover[$key+$mainImage_id];
        }
    }
    if(@$request->mainImage_id){
        $request->mainImage_id = @$request->mainImage_id ?: [];
        $images[$request->mainImage_id]['ord'] = 0;
        $images[$request->mainImage_id]['cover'] = $request->cover[0];
    }
    $data->images()->sync($images);

    return $data->fresh();
  }

  public function show($id)
  {
    if (Cache::has('Blog')){
      $blog = Cache::get('Blog')->find($id);
    } else {
      $blog = Blog::find($id);
    }
    return $blog;
  }

  public function edit($id)
  {
    if (Cache::has('Blog')){
        $blog = Cache::get('Blog')->find($id);
    } else {
        $blog =  Blog::find($id);
    }
    return $blog;
  }

  public function getBlogCategory()
  {
    $blogCategories = BlogCategory::where('parent_id', null)->orderBy('position','desc')->get();
    return $blogCategories;
  }

  public function getBlogCategoryIds()
  {
    $catIds = [];
    $blogCategories = BlogCategory::where('parent_id', null)->orderBy('position','desc')->get();
    foreach($blogCategories as $category){
        array_push($catIds,$category->id);
    }
    return $catIds;
  }

  public function update($request)
  {
    Cache::forget('Blog');
    $locales = getLocales();
    
    $valid = [
        'status' => 'required|integer',
    ];

    foreach ($locales as $loc) {
        if ($loc->status == 1) {
            $valid['title_' . $loc->code] = 'required|string';
        }
    }

    request()->validate($valid);

    $data = Blog::findOrFail($request->id);

    foreach ($locales as $locale) {
        $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
        $data->setTranslation('content',$locale->code,$request->input('content_' . $locale->code));
        $data->setTranslation('slug',$locale->code,str::slug($request->input('title_' . $locale->code)));
    }
    $data->status = $request->status;
    if(!is_null($request->blogCategory))
    {
        $data->modelCategory()->sync($request->blogCategory);
    }
    $data->save();

    if(!empty($request->input('seoTitles_' . app()->getLocale()))){
        if(!empty($data->seo()->first())){
           $seo =  Seo::findOrFail($data->seo()->first()->id);
       }else{
           $seo = new Seo;
       }
        foreach ($locales as $locale) {
            $seo->setTranslation('seoTitles',$locale->code,$request->input('seoTitles_' . $locale->code));
            $seo->setTranslation('seoKeywords',$locale->code,$request->input('seoKeywords_' . $locale->code));
            $seo->setTranslation('seoDescriptions',$locale->code,$request->input('seoDescriptions_' . $locale->code));
        }
        $data->seo()->save($seo);
    }

    Cache::forget('generalBlog'.$data->id);
    Cache::forget('statusImageShowBlog'.$data->id);

    $images = [];
    if(@$request->images){
        $request->images = @$request->images ?: [];
        $mainImage_id = empty($request->mainImage_id) ? 0 : 1;
        foreach ($request->images as $key => $value){
          $images[$value]['ord'] = $key+1;
          $images[$value]['cover'] = $request->cover[$key+$mainImage_id];
        }
    }
    if(@$request->mainImage_id){
        $request->mainImage_id = @$request->mainImage_id ?: [];
        $images[$request->mainImage_id]['ord'] = 0;
        $images[$request->mainImage_id]['cover'] = $request->cover[0];
    }
    $data->images()->sync($images);

    return $data->fresh();
  }

  public function destroy($id)
  {
    Cache::forget('Blog');
    $destroy = Blog::find($id)->delete();
    return $destroy;
  }

  public function massDestroy($request)
  {
    Cache::forget('Blog');
    Blog::whereIn('id', $request->ids)->delete();
    return response('massDestroy Successfully.', 200);
  }

  public function reorder($request)
  {
    Cache::forget('Blog');
    foreach($request->rows as $row)
    {
      Blog::find($row['id'])->update([
          'position' => $row['position']
      ]);
    }
    return response('Update Successfully.', 200);
  }

  public function trash($request)
  {
    if ($request->ajax()) {
        $query = Blog::onlyTrashed();
        $table = Datatables::of($query);
        $table->addColumn('placeholder', '&nbsp;');
        $table->addColumn('actions', 'მოქმედება');

        $table->editColumn('actions', function ($row) {
            $restoreGate = 'backend.blogs.restore';
            $removeGate  = 'backend.blogs.remove';

            return view('backend.partials.datatablesTrashActions', compact(
                'restoreGate',
                'removeGate',
                'row'
            ));
        });

        $table->editColumn('id', function ($row) {
            return $row->id ? $row->id : "";
        });
        $table->editColumn('position', function ($row) {
            return $row->position ? $row->position : "";
        });
        $table->editColumn('title', function ($row) {
            return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
        });
        $table->editColumn('category', function ($row) {
            return view('backend.partials.datatablesParentId', compact(
                'row'
            ));
        });

        $table->editColumn('images', function ($row) {
            return view('backend.partials.datatablesImages', compact(
                'row'
            ));
        });

        $table->rawColumns(['actions', 'placeholder']);

        return $table->make(true);
    }
    return view('backend.blogs.trash');
  }  

  public function restore($request) 
  {
    Cache::forget('Blog');
    $blog = Blog::where('id', $request->id)->withTrashed()->first();
    $blog->restore();

    return $blog->fresh();
  }

  public function remove($request)
  {
    Cache::forget('Blog');
    $blog = Blog::where('id', $request->id)->withTrashed()->first();
    $blog->seo()->forceDelete();
    $blog->images()->detach();
    Cache::forget('generalBlog'.$blog->id);
    Cache::forget('statusImageShowBlog'.$blog->id);        
    $blog->forceDelete();

    return $blog->fresh();
  }

  public function massRemove($request)
  {
    Cache::forget('Blog');
    $blogs = Blog::whereIn('id', $request->ids)->get();
    foreach ($blogs as $blog) {
      Cache::forget('generalBlog'.$blog->id);
      Cache::forget('statusImageShowBlog'.$blog->id);
      $blog->seo()->forceDelete();
      $blog->images()->detach();
    }

    Blog::whereIn('id', $request->ids)->withTrashed()->forceDelete();
    return response('massRemove Successfully.', 200);
  }
}