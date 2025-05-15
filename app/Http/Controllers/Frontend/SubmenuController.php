<?php

namespace App\Http\Controllers;

use App\Helpers\Core\Helper;
use Illuminate\Http\Request;
use PHPUnit\TextUI\Help;

class SubmenuController extends Controller
{
    public function index(Request $request)
    {
        $menu = \App('menu');
        $data = Helper::pageTemplate($menu);
        $content = $menu->menu->children()->withAndHas('info', function($query) {
            $query->where('language_id', Helper::languageId());
        })->get();

        $parent_slug = $menu->ancestors ?? $menu->slug;

        return view('site.page.' . $data['type']['name'] . '.' . $data['template']['name'], [
            'content' => $content,
            "parent_slug" => $parent_slug,
        ]);

    }
}
