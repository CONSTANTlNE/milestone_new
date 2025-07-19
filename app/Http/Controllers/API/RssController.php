<?php

namespace App\Http\Controllers\API;

use App\Models\Blog;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Response;

class RssController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function rss(\Request $request)
    {
        $content = Blog::orderBy('id', 'DESC')->with('covers')->limit(20)->get();
        $view = \View::make('rss.feed')->with(['data' => $content]);
        return \Response::make($view, '200')->header('Content-Type', 'text/xml');
    }

    /**
     * @param $slug
     * @return Application|Factory|View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function view($slug)
    {
        return view('rss.view', [
            'content' => [],
            'title' => 'Short title about your blog',
        ]);
    }
}
