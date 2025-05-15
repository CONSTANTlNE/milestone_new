<?php

namespace App\Http\Controllers;

use Multitenant;
use Helper;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * [$type description]
     * @var [type]
     */
    protected $type;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $data = \App('menu');
        
        $banners = Multitenant::getModel('Banner')::where('status', config('banner.status.active.id'))->withAndHas('info', function ($query) {
                $query->where('language_id', Helper::languageId());
                $query->with('covers');
            })->get();

        return view('widgets.banners', ['data' => $data, 'banners' => $banners]);
    }
}
