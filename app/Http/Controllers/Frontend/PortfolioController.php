<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;

class PortfolioController extends Controller
{
    public function index()
    {
        $page = Page::where('template', 'frontend.portfolios.index')->first();
        $portfolios = Portfolio::whereNotNull('slug->' . app()->getLocale())
        ->where('slug->'. app()->getLocale(), "!=", '')
        ->where('status', 1)
        ->orderBy('id', 'DESC')
        ->paginate(12);
        return view('frontend.portfolios.index', compact('portfolios', 'page'));
    }

    public function show($id)
    {
        $portfolio = Portfolio::where('status','1')->where('id', $id)->first();
        return view('frontend.portfolios.show', compact('portfolio'));
    }
}
