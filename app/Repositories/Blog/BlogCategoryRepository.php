<?php

namespace App\Repositories\Blog;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\BaseRepository;
use App\Interfaces\Blog\BlogCategoryRepositoryInterface;

use App\Http\Requests\Blog\CreateBlogCategory;
use App\Http\Requests\Blog\UpdateBlogCategory;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\Seo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Validator;
use Gate;
use Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class BlogCategoryRepository extends BaseRepository implements BlogCategoryRepositoryInterface {

	const CACHE_TTL = 86400; // 1 day

	public function index($request)
	{

	  if ($request->ajax()) {
	      if (Cache::has('BlogCategory')){
	          $query = Cache::get('BlogCategory');
	      } else {
	          $query = Cache::remember('BlogCategory', self::CACHE_TTL, function (){
	              return BlogCategory::all();
	          });
	      }
	      $table = Datatables::of($query);
	      $table->addColumn('placeholder', '&nbsp;');
	      $table->addColumn('actions', 'მოქმედება');

	      $table->editColumn('actions', function ($row) {
	          $showGate      = 'backend.blogCategory.show';
	          $editGate      = 'backend.blogCategory.edit';
	          $destroyGate    = 'backend.blogCategory.destroy';
	          $statusGate    = 'backend.blogCategory.status';

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

	  return view('backend.blogCategory.index');
	}

	public function getlist()
	{
		if (Cache::has('BlogCategory')){
			$allBlogCategories = Cache::get('BlogCategory');
		} else {
			$allBlogCategories = Cache::remember('BlogCategory', self::CACHE_TTL, function (){
		  		return BlogCategory::all();
			});
		}

		return $allBlogCategories;
	}

	public function getSeoFirst($id)
	{
		$blogCategory = BlogCategory::find($id);
		return $blogCategory->seo()->first();
	}

	public function status($request)
	{
		Cache::forget('BlogCategory');
		$blogCategory = BlogCategory::find($request->model_id);
		$blogCategory->status = $request->status;
		$blogCategory->save();
		return response()->json(['success'=>'სტატუსი წარმატებით შეიცვალა!']);
	}

	public function create()
	{
		if (Cache::has('BlogCategory')){
		    $blogCategories = Cache::get('BlogCategory');
		}else{
		    $blogCategories = BlogCategory::where('status','1')->orderBy('id','desc')->get();
		}
		return $blogCategories;
	}

	public function store($request)
	{
		Cache::forget('BlogCategory');
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

		$data = new BlogCategory();
		foreach ($locales as $locale) {
		  $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
		  $data->setTranslation('slogan',$locale->code,$request->input('slogan_' . $locale->code));
		  $data->setTranslation('content',$locale->code,$request->input('content_' . $locale->code));
		  $data->setTranslation('slug',$locale->code,str::slug($request->input('title_' . $locale->code)));
		}
		$data->status = $request->status;
		if($request->parent_id){
		  $data->parent_id = $request->parent_id;
		}
		$data->position = BlogCategory::max('position') + 1;
		$data->save();

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
		if (Cache::has('BlogCategory')){
		  $blogCategory = Cache::get('BlogCategory')->find($id);
		} else {
		  $blogCategory = BlogCategory::find($id);
		}
		return $blogCategory;
	}

	public function edit($id)
	{
		if (Cache::has('BlogCategory')){
		  $blogCategory = Cache::get('BlogCategory')->find($id);
		} else {
		  $blogCategory = BlogCategory::find($id);
		}
		return $blogCategory;
	}

	public function update($request)
	{
		Cache::forget('BlogCategory');
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

		$data = BlogCategory::findOrFail($request->id);

		foreach ($locales as $locale) {
		  $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
		  $data->setTranslation('slogan',$locale->code,$request->input('slogan_' . $locale->code));
		  $data->setTranslation('content',$locale->code,$request->input('content_' . $locale->code));
		  $data->setTranslation('slug',$locale->code,str::slug($request->input('title_' . $locale->code)));
		}
		$data->status = $request->status;
		if($request->parent_id){
		  $data->parent_id = $request->parent_id;
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

		Cache::forget('generalBlogCategory'.$data->id);
		Cache::forget('statusImageShowBlogCategory'.$data->id);

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
		Cache::forget('BlogCategory');
		$destroy = BlogCategory::find($id)->delete();
		return $destroy;
	}

	public function massDestroy($request)
	{
		Cache::forget('BlogCategory');
		BlogCategory::whereIn('id', $request->ids)->delete();
		return response('massDestroy Successfully.', 200);
	}

	public function reorder($request)
	{
		Cache::forget('BlogCategory');
		foreach($request->rows as $row)
		{
		  BlogCategory::find($row['id'])->update([
		      'position' => $row['position']
		  ]);
		}
		return response('Update Successfully.', 200);
	}

	public function trash($request)
	{
		if ($request->ajax()) {
		  $query = BlogCategory::onlyTrashed();
		  $table = Datatables::of($query);
		  $table->addColumn('placeholder', '&nbsp;');
		  $table->addColumn('actions', 'მოქმედება');

		  $table->editColumn('actions', function ($row) {
		      $restoreGate = 'backend.blogCategory.restore';
		      $removeGate  = 'backend.blogCategory.remove';

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
		return view('backend.blogCategory.trash');
	}

	public function restore($request) 
	{
		Cache::forget('BlogCategory');
		$blogCategory = BlogCategory::where('id', $request->id)->withTrashed()->first();
		$blogCategory->restore();

		return $blogCategory->fresh();
	}

	public function remove($request)
	{
		Cache::forget('BlogCategory');
		$blogCategory = BlogCategory::where('id', $request->id)->withTrashed()->first();
		$blogCategory->seo()->forceDelete();
		$blogCategory->images()->detach();
		Cache::forget('generalBlogCategory'.$blogCategory->id);
		Cache::forget('statusImageShowBlogCategory'.$blogCategory->id);        
		$blogCategory->forceDelete();

		return $blogCategory->fresh();
	}

	public function massRemove($request)
	{
		Cache::forget('BlogCategory');
		$blogCategorys = BlogCategory::whereIn('id', $request->ids)->get();
		foreach ($blogCategorys as $blogCategory) {
		  Cache::forget('generalBlogCategory'.$blogCategory->id);
		  Cache::forget('statusImageShowBlogCategory'.$blogCategory->id);
		  $blogCategory->seo()->forceDelete();
		  $blogCategory->images()->detach();
		}

		BlogCategory::whereIn('id', $request->ids)->withTrashed()->forceDelete();
		return response('massRemove Successfully.', 200);
	}
}