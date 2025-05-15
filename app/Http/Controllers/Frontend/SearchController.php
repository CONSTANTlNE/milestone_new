<?php

namespace App\Http\Controllers;

use App\Helpers\Core\Helper;
use Multitenant;
use App\Models\Core\Menu;
use Illuminate\Http\Request;
use App\Http\Resources\User;
use App\Events\Article\ArticleRead;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $words = isset($request->search) ? explode(" ", $request->search) : null;
        $page_id = intval(isset($request->page_id) ? $request->page_id : null);
        $user = null;

        if ($request->page_id === 'byReporters') {
            $page_id = $request->page_id;
            $user = Multitenant::getModel('User')::query();
            $user->select('*');
            $user = $user->withAndHas('info', function ($query) use ($words) {
                if (!is_null($words)) {
                    $query->where('name', 'LIKE', '%'.implode(' ', $words).'%');
                }
            })->first();
        }

        $content = Multitenant::getModel('ContentLanguage')::query();
        $content = $content->select('*');
        
        if (!is_null($words) && is_null($user)) {
            foreach ($words as $word) {
                $content->search($word);
                // $content->orWhere('title', 'LIKE', '%'.$word.'%');
                // $content->orWhere('text', 'LIKE', '%'.$word.'%');
                // $content->orWhere('description', 'LIKE', '%'.$word.'%');
            }
        }

        $content = $content->orderBy('published_at', 'DESC')
            ->with('covers')
            ->where('published_at', '<=', \Carbon\Carbon::now()->format('Y-m-d H:i:s'))
            ->where('language_id', Helper::languageId());
        if ($page_id > 0) {
            $content = $content->withAndHas('content', function ($query) use ($page_id) {
                $query->withAndHas('pages', function ($query) use ($page_id) {
                    $query->where('id', $page_id);
                });
            });
        } else {
            if ($user) {
                $content = $content->withAndHas('content', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                });
            } else {
                $content = $content->with('content');
            }
        }

        $content = $content->paginate(config('content.pagination.limit'));
        // dd($content->lastPage());

        return view('site.page.search', ['content' => $content]);
    }
}
