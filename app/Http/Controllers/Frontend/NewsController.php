<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Events\Article\ArticleRead;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * [$type description]
     * @var [type]
     */
    protected $type;

    /**
     * Show the application dashboard.
     *
     * @return Application|Factory|\Illuminate\Foundation\Application|\Illuminate\View\View|View
     */

    public function index($lang)
    {
        $articles = Blog::whereNotNull('slug->' . $lang)
        ->where('slug->'.$lang, "!=", '')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->paginate(15);
        return view('frontend.articles.index', compact('articles'));
    }

    /**
     * @param $lang
     * @param $tagId
     * @return Application|Factory|View|\Illuminate\Foundation\Application|RedirectResponse|\Illuminate\View\View
     */
    public function byTag($lang, $tagId)
    {
        $tag = Tag::where('lang', $lang)->where('id', $tagId)->first();
        if (!$tag){
            return redirect()->route('frontend.index', $lang);
        }
        $tagArticles = $tag->articles()
            ->whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return view('frontend.articles.tag', compact('tag', 'tagArticles'));
    }

    public function reporter($lang, $id)
    {
        $reporter = User::find($id);
        $reporterArticles = $reporter->articles()
            ->whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(15);
        return view('frontend.articles.reporter', compact('reporter', 'reporterArticles'));
    }

    public function category($lang, $id)
    {
        $category = BlogCategory::find($id);
        if($category->children->isNotEmpty()){
            $categoryIds = $category->children->pluck('id');
            $categoryArticles = Blog::whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
                ->whereNotNull('slug->' . $lang)
                ->where('slug->'.$lang, "!=", '')
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->paginate(15);
        }else{
             $categoryArticles = $category->articles()
                ->whereNotNull('slug->' . $lang)
                ->where('slug->'.$lang, "!=", '')
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->paginate(15);
        }

        return view('frontend.articles.category', compact('category', 'categoryArticles'));
    }

    /**
     * [show description]
     * @param $lang
     * @param $id
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View [type]       [description]
     */
    public function show($lang, $id)
    {
        $article = Blog::whereNotNull('slug->'.$lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('id', $id)
            ->first();
        //event(new ArticleRead($article));
        return view('frontend.articles.show', compact('article'));
    }

    public function fourNews() {
        $content = Multitenant::getModel('ContentLanguage')::orderBy('published_at', 'DESC')
                ->with(['covers'])
                ->withAndHas('content', function ($query) {
                    $query->where('type', Config('content.types.article'));
                })
                ->where('published_at', '<=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
                ->where('language_id', Helper::languageId())->limit(4)->get();
        return $content;
    }
}
