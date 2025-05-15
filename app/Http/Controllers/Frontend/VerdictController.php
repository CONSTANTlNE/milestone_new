<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Verdict;

class VerdictController extends Controller
{
    public function index($lang)
    {
        $articles = Article::whereNotNull('slug->' . $lang)
        ->where('slug->'.$lang, "!=", '')
        ->where('verdict_id', '!=', null)
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->paginate(12);
        return view('frontend.verdicts.index', compact('articles'));
    }

    public function show($lang, $id)
    {
        $verdict = Verdict::where('status','1')->where('id', $id)->first();
        $verdictArticles = $verdict->articles()->orderBy('id', 'DESC')->paginate(15);
        return view('frontend.verdicts.show', compact('verdict', 'verdictArticles'));
    }
}
