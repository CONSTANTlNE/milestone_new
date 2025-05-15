<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locale;

class LanguageTranslationController extends Controller
{

    public function index(Request $request)
    {
        $languages = Locale::where('status', 1)->orderby('default','desc')->get();
        $default = Locale::where('default', 1)->first();
        $columns = [];
        $columnsCount = $languages->count();
        if($languages->count() > 0){
            $columns[0] = openJSONFile($default->code);
            $i=1;
            foreach ($languages as $language){
                $columns[$i++] = ['data'=> openJSONFile($language->code), 'lang'=>$language->code];
            }
        }
       return view('backend.locales.static.index', compact('languages','columns','default','columnsCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'localeKey' => 'required',
            'localeValue' => 'required',
        ]);
        $default_lang = Locale::where('default', 1)->first();
        $data = openJSONFile($default_lang->code);
        $data[$request->localeKey] = $request->localeValue;
        saveJSONFile($default_lang->code, $data);

        return redirect()->route('backend.locales.static.index', app()->getLocale());
    }

    public function destroy(Request $request)
    {
        $languages = Locale::where('status', 1)->get();

        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = openJSONFile($language->code);
                unset($data[$request->key]);
                saveJSONFile($language->code, $data);
            }
        }
        return response()->json(['success' => $request->key]);
    }

    public function transUpdate(Request $request){
        $data = openJSONFile($request->code);
        $data[$request->pk] = $request->value;
        saveJSONFile($request->code, $data);
        return response()->json(['success'=>'Done!']);
    }

    public function transUpdateKey(Request $request){
        $languages = Locale::where('status', 1)->get();

        if($languages->count() > 0){
            foreach ($languages as $language){
                $data = openJSONFile($language->code);
                if (isset($data[$request->pk])){
                    $data[$request->value] = $data[$request->pk];
                    unset($data[$request->pk]);
                    saveJSONFile($language->code, $data);
                }
            }
        }
        return response()->json(['success'=>'Done!']);
    }
}
