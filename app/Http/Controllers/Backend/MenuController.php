<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Projects\ServiceCategoryController;
use App\Models\BlogCategory;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Person;
use App\Models\Region;
use App\Models\ServiceCategory;
use App\Models\Verdict;
use Gate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all();
        return view('backend.menus.index', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'menuValue' => 'required',
            'block' => 'required',
        ]);
        $menu = new Menu();
        $menu->name = $request->menuValue;
        $menu->block = $request->block;
        $menu->save();
        return redirect()->route('backend.menus.index');
    }
    const CACHE_TTL = 86400; // 1 day

    public function edit($id)
    {
        $menu = Menu::find($id);

        $menuItems = MenuItem::select('id', 'parent_id', 'depth', 'sort', 'title',  'slug', 'model_id', 'route', 'is_prefix', 'status')
                    ->where('menu_id', $id)
                    ->where('status', 1)
                    ->with('children')
                    ->orderBy('sort', 'asc')
                    ->get();

        // Additional debugging to check for duplicates
        $itemIds = $menuItems->pluck('id')->toArray();
        $duplicateIds = array_diff_assoc($itemIds, array_unique($itemIds));

        if (!empty($duplicateIds)) {
            \Log::warning('Duplicate menu items detected', [
                'duplicate_ids' => $duplicateIds,
                'menu_id' => $id
            ]);
        }

        // Debug: Log menu items structure
        \Log::info('Menu Items Structure', [
            'menu_id' => $id,
            'items_count' => $menuItems->count(),
            'items' => $menuItems->map(function($item) {
                return [
                    'id' => $item->id,
                    'parent_id' => $item->parent_id,
                    'depth' => $item->depth,
                    'title' => $item->title
                ];
            })->toArray()
        ]);

        $pages = Page::all();
        $serviceCategories = ServiceCategory::all();
        $blogCategories = BlogCategory::all();
        return view('backend.menus.edit', compact('menu', 'menuItems', 'pages', 'serviceCategories', 'blogCategories'));
    }

    public function destroy($id)
    {
        Menu::find($id)->delete();
        MenuItem::where('menu_id', $id)->delete();
        Cache::forget('menuItem_'.$id);
        return redirect()->route('backend.menus.index')
            ->with('success', __('strings.Delete Successfully'));
    }
    public function deleteMenu()
    {
        Cache::forget('menuItem_'.request()->input("idmenu"));
        $menus = new MenuItem();
        $all = $menus->getAll(request()->input("id"));
        if (count($all) == 0) {
            $menu = Menu::find(request()->input("id"));
            $menu->delete();
            return json_encode(array("resp" => __("strings.deleting_this_menu")));
        }
        return json_encode(array("resp" => __("strings.delete_all_items"), "error" => 1));
    }

    public function updateMenu()
    {
        Cache::forget('menuItem_'.request()->input("idmenu"));
        $menu = Menu::find(request()->input("idmenu"));
        $menu->name = request()->input("menuname");
        $menu->save();
        if (is_array(request()->input("arraydata"))) {
            foreach (request()->input("arraydata") as $value) {
                $menuItem = MenuItem::find($value["id"]);
                $menuItem->parent_id = $value["parent"];
                $menuItem->sort = $value["sort"];
                $menuItem->depth = $value["depth"];
                $menuItem->save();
            }
        }
        return json_encode(array("resp" => 1));
    }

    public function deleteMenuItem()
    {
        Cache::forget('menuItem_'.request()->input("idmenu"));
        $menuItem = MenuItem::find(request()->input("id"));
        $menuItem->delete();
    }

    public function deleteAllMenuItems()
    {
        $menuId = request()->input("menu_id");

        if ($menuId) {
            // Delete all menu items for a specific menu
            $deletedCount = MenuItem::where('menu_id', $menuId)->delete();
            Cache::forget('menuItem_'.$menuId);

            return response()->json([
                'success' => true,
                'message' => __('strings.All menu items deleted successfully'),
                'deleted_count' => $deletedCount
            ]);
        } else {
            // Delete all menu items from all menus
            $deletedCount = MenuItem::truncate();

            // Clear all menu caches
            $menus = Menu::all();
            foreach ($menus as $menu) {
                Cache::forget('menuItem_'.$menu->id);
            }

            return response()->json([
                'success' => true,
                'message' => __('strings.All menu items deleted successfully'),
                'deleted_count' => 'all'
            ]);
        }
    }

    public function updateMenuItem()
    {
        Cache::forget('menuItem_'.request()->input("idmenu"));
        $arrayData = request()->input("arraydata");
        if (is_array($arrayData)) {
            foreach ($arrayData as $value) {
                $menuItem = MenuItem::find($value['id']);
                $menuItem->class = $value['class'];
                $menuItem->save();
            }
        } else {
            $menuItem = MenuItem::find(request()->input("id"));
            $menuItem->class = request()->input("clases");
            $menuItem->save();
        }
    }

    public function addMenuItem()
    {
        Cache::forget('menuItem_'.request()->input("idmenu"));
        $menuTitle = explode("|", request()->menuTitle);
        $menuPrefix = $menuTitle[0] == 0 ? explode("-", request()->input("menuPrefix"))[0] : str_replace("-", ".", request()->input("menuPrefix"));
        $menuItem = new MenuItem();
        $menuItem->setTranslations('title', json_decode($menuTitle[1], true, JSON_UNESCAPED_UNICODE));
        $menuItem->setTranslations('slug', json_decode($menuTitle[2], true, JSON_UNESCAPED_UNICODE));
        $menuItem->route = $menuTitle[3] ?? $menuPrefix;
        $menuItem->is_prefix = $menuTitle[0] == 0 ? 0 : 1;
        $menuItem->model_id = int_value($menuTitle[0]);
        $menuItem->model_type = request()->menuModel;
        $menuItem->menu_id = request()->input("idmenu");
        $menuItem->sort = MenuItem::getNextSortRoot(request()->input("idmenu"));
        $menuItem->save();
    }

    public function select($name = "menu", $menulist = array())
    {
        $html = '<select name="' . $name . '">';

        foreach ($menulist as $key => $val) {
            $active = '';
            if (request()->input('menu') == $key) {
                $active = 'selected="selected"';
            }
            $html .= '<option ' . $active . ' value="' . $key . '">' . $val . '</option>';
        }
        $html .= '</select>';
        return $html;
    }


    /**
     * Returns empty array if menu not found now.
     * Thanks @sovichet
     *
     * @param $name
     * @return array
     */
    public static function getByName($name)
    {
        $menu = Menu::byName($name);
        return is_null($menu) ? [] : self::get($menu->id);
    }

    public static function get($menu_id)
    {
        $menuItem = new MenuItem;
        $menu_list = $menuItem->getAll($menu_id);

        $roots = $menu_list->where('menu_id', (integer) $menu_id)->where('parent_id', 0);

        $items = self::tree($roots, $menu_list);
        return $items;
    }

    private static function tree($items, $all_items)
    {
        $data_arr = array();
        $i = 0;
        foreach ($items as $item) {
            $data_arr[$i] = $item->toArray();
            $find = $all_items->where('parent_id', $item->id);

            $data_arr[$i]['child'] = array();

            if ($find->count()) {
                $data_arr[$i]['child'] = self::tree($find, $all_items);
            }

            $i++;
        }

        return $data_arr;
    }
}
