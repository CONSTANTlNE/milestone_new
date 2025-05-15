<?php

namespace App\Http\Controllers;

use App\Models\Core\Menu;
use Illuminate\Http\Request;

class TextController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = \App('menu');

        $type = array_first(collect(config('page.types'))->filter(function ($type) use ($data) {
            return $type['id'] === $data->menu->page->type;
        }));

        $template = array_first(collect(config('page.templates')[$type['name']])->filter(function ($template) use ($type, $data) {
            return $template['id'] === (int) $data->menu->page->template_id;
        }));

        $text = $data->menu->page->info->text;
        return view('site.page.' . $type['name'] . '.' . $template['name'], ['text' => $text]);
    }
}
