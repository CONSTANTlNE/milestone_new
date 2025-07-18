<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Region;

class RegionController extends Controller
{
    public function index($lang)
    {
        $articles = Blog::whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('verdict_id', '!=', null)
            ->where('status', 1)
            ->has('regions')
            ->with('regions')
            ->orderBy('id', 'DESC')
            ->paginate(12);
        return view('frontend.regions.index', compact('articles'));
    }

    public function show($lang, $id)
    {
        $region = Region::where('status','1')->where('id', $id)->first();
        $regionArticles = $region->articles()
            ->whereNotNull('slug->' . $lang)
            ->where('slug->'.$lang, "!=", '')
            ->where('status', 1)
            ->orderBy('id', 'DESC')
            ->paginate(12);
        return view('frontend.regions.show', compact('region','regionArticles'));
    }
}
