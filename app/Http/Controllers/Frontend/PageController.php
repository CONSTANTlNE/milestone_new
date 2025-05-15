<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Response;

class PageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function show($lang, $id)
    {
        $page = Page::findOrFail($id);

        if (is_null($page)) {
            abort(404);
        }

        if (is_null($page->title)) {
            abort(404);
        }

        if ($page->id == 268){
            $contact = Setting::first();
            return view('frontend.page.contact', compact('contact'));
        }else if($page->id == 285){
            return view('frontend.page.check_fact', compact('page'));
        }else{
            return view('frontend.page.show', compact('page'));
        }
    }

    public function factInMedia($lang){
        $factInMedias = Media::where('title->'.$lang, "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(24);
        return view('frontend.articles.fact_in_media', compact('factInMedias'));
    }
}
