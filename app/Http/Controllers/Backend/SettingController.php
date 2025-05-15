<?php
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Traits\MultiTranslatableTrait;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    use MultiTranslatableTrait;

    public function edit($lang, $id)
    {
        return view('backend.settings.edit', [
            'setting' => Setting::first()
        ]);
    }

    public function update(Request $request, $lang, Setting $setting)
    {
        $setting->updateSettings($request->all());
        return redirect()->back();
    }
}
