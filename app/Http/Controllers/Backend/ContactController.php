<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Validator;
use DB;
use Gate;
use Config;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class ContactController extends Controller
{
    const CACHE_TTL = 86400; // 1 day

    public function index(Request $request)
    {
        if (Gate::denies('backend.contacts.index')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        if ($request->ajax()) {
            if (Cache::has('Contact')){
                $query = Cache::get('Contact');
            } else {
                $query = Cache::remember('Contact', self::CACHE_TTL, function (){
                    return Contact::all();
                });
            }
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', 'მოქმედება');

            $table->editColumn('actions', function ($row) {
                $showGate      = 'backend.contacts.show';
                $editGate      = 'backend.contacts.edit';
                $destroyGate    = 'backend.contacts.destroy';
                $statusGate    = 'backend.contacts.status';

                return view('backend.partials.datatablesActions', compact(
                    'statusGate',
                    'showGate',
                    'editGate',
                    'destroyGate',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : "";
            });
            $table->editColumn('title', function ($row) {
                return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
            });
            $table->editColumn('category', function ($row) {
                
            });

            $table->editColumn('images', function ($row) {
                return view('backend.partials.datatablesImages', compact(
                    'row'
                ));
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('backend.contacts.index');
    }

    public function status(Request $request)
    {
        if (Gate::denies('backend.contacts.status')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        $contact = Contact::find($request->model_id);
        $contact->status = $request->status;
        $contact->save();
        return response()->json(['success'=>'სტატუსი წარმატებით შეიცვალა!']);
    }

    public function create()
    {
        if (Gate::denies('backend.contacts.create')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        return view('backend.contacts.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('backend.contacts.store')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        $locales = getLocales();

        $valid = [
            'status' => 'required|integer',
        ];

        foreach ($locales as $loc) {
            if ($loc->status == 1) {
                $valid['title_' . $loc->code] = 'required|string';
            }
        }

        request()->validate($valid);

        $data = new Contact();
        foreach ($locales as $locale) {
            $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
            $data->setTranslation('startDate',$locale->code,$request->input('startDate_' . $locale->code));
            $data->setTranslation('address',$locale->code,$request->input('address_' . $locale->code));
        }
        $data->status = $request->status;
        $data->phone = $request->phone;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->email1 = $request->email1;
        $data->link = $request->link;
        $data->position = Contact::max('position') + 1;
        $data->save();
        
        $images = [];
        if(@$request->images){
            $request->images = @$request->images ?: [];
            $mainImage_id = empty($request->mainImage_id) ? 0 : 1;
            foreach ($request->images as $key => $value){
              $images[$value]['ord'] = $key+1;
              $images[$value]['cover'] = $request->cover[$key+$mainImage_id];
            }
        }
        if(@$request->mainImage_id){
            $request->mainImage_id = @$request->mainImage_id ?: [];
            $images[$request->mainImage_id]['ord'] = 0;
            $images[$request->mainImage_id]['cover'] = $request->cover[0];
        }

        $data->images()->sync($images);

        return redirect()->route('backend.contacts.index', app()->getLocale())
                        ->with('success','წარმატებით დაემატა!');
    }

    public function show(Request $request)
    {
        if (Gate::denies('backend.contacts.show')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index');
        }
        if (Cache::has('Contact')){
            $contact = Cache::get('Contact')->find($request->id);
        } else {
            $contact =  Contact::find($request->id);
        }
        return view('backend.contacts.show',compact('contact'));
    }

    public function edit(Request $request)
    {
        if (Gate::denies('backend.contacts.edit')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        if (Cache::has('Contact')){
            $contact = Cache::get('Contact')->find($request->id);
        } else {
            $contact =  Contact::find($request->id);
        }
        return view('backend.contacts.edit',compact('contact'));
    }

    public function update(Request $request)
    {
        if (Gate::denies('backend.contacts.update')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        
        Cache::forget('Contact');

        $locales = getLocales();
        
        $valid = [
            'status' => 'required|integer',
        ];

        foreach ($locales as $loc) {
            if ($loc->status == 1) {
                $valid['title_' . $loc->code] = 'required|string';
            }
        }

        request()->validate($valid);

        $data = Contact::findOrFail($request->id);

        foreach ($locales as $locale) {
            $data->setTranslation('title',$locale->code,$request->input('title_' . $locale->code));
            $data->setTranslation('startDate',$locale->code,$request->input('startDate_' . $locale->code));
            $data->setTranslation('address',$locale->code,$request->input('address_' . $locale->code));
        }
        $data->status = $request->status;
        $data->phone = $request->phone;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->email1 = $request->email1;
        $data->link = $request->link;
        $data->save();

        Cache::forget('generalContact'.$data->id);
        Cache::forget('statusImageShowContact'.$data->id);

        $images = [];
        if(@$request->images){
            $request->images = @$request->images ?: [];
            $mainImage_id = empty($request->mainImage_id) ? 0 : 1;
            foreach ($request->images as $key => $value){
              $images[$value]['ord'] = $key+1;
              $images[$value]['cover'] = $request->cover[$key+$mainImage_id];
            }
        }
        if(@$request->mainImage_id){
            $request->mainImage_id = @$request->mainImage_id ?: [];
            $images[$request->mainImage_id]['ord'] = 0;
            $images[$request->mainImage_id]['cover'] = $request->cover[0];
        }

        $data->images()->sync($images);

        return redirect()->route('backend.contacts.index', app()->getLocale())
                        ->with('success','წარმატებით განახლდა!');
    }

    public function destroy(Request $request)
    {
        if (Gate::denies('backend.contacts.destroy')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        Contact::find($request->id)->delete();
        return redirect()->route('backend.contacts.index', app()->getLocale())
                        ->with('success','წარმატებით წაიშალა!');
    }

    public function massDestroy(Request $request)
    {
        Cache::forget('Contact');
        Contact::whereIn('id', $request->ids)->delete();
        return response('massDestroy Successfully.', 200);
    }

    public function reorder(Request $request)
    {
        Cache::forget('Contact');
        foreach($request->rows as $row)
        {
            Contact::find($row['id'])->update([
                'position' => $row['position']
            ]);
        }
        return response('Update Successfully.', 200);
    }

    public function trash(Request $request)
    {

        if (Gate::denies('backend.contacts.trash')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }

        if ($request->ajax()) {
            $query = Contact::onlyTrashed();
            $table = Datatables::of($query);
            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', 'მოქმედება');

            $table->editColumn('actions', function ($row) {
                $restoreGate = 'backend.contacts.restore';
                $removeGate  = 'backend.contacts.remove';

                return view('backend.partials.datatablesTrashActions', compact(
                    'restoreGate',
                    'removeGate',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->editColumn('position', function ($row) {
                return $row->position ? $row->position : "";
            });
            $table->editColumn('title', function ($row) {
                return Str::limit($row->getTranslation('title', app()->getLocale()), 30);
            });
            $table->editColumn('category', function ($row) {
                
            });

            $table->editColumn('images', function ($row) {
                return view('backend.partials.datatablesImages', compact(
                    'row'
                ));
            });

            $table->rawColumns(['actions', 'placeholder']);

            return $table->make(true);
        }

        return view('backend.contacts.trash');
    }

    public function restore(Request $request) 
    {
        if (Gate::denies('backend.contacts.restore')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        $contact = Contact::where('id', $request->id)->withTrashed()->first();
        $contact->restore();

        return redirect()->route('backend.contacts.trash', app()->getLocale())
                        ->with('success','ჩანაწერი წარმატებით აღადგინეთ!');
    }

    public function remove(Request $request)
    {
        if (Gate::denies('backend.contacts.remove')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        $contact = Contact::where('id', $request->id)->withTrashed()->first();
        $contact->images()->detach();
        Cache::forget('generalContact'.$contact->id);
        Cache::forget('statusImageShowContact'.$contact->id);   
        $contact->forceDelete();
        return redirect()->route('backend.contacts.trash', app()->getLocale())
                        ->with('success','წარმატებით წაიშალა!');
    }

    public function massRemove(Request $request)
    {
        if (Gate::denies('backend.contacts.remove')) {
            session()->flash('error', 'თქვენ არ გაქვთ უფლება და წვდომა ამ გვერდზე!');
            return redirect()->route('backend.index', app()->getLocale());
        }
        Cache::forget('Contact');
        $contacts = Contact::whereIn('id', $request->ids)->get();
        foreach ($contacts as $contact) {
            Cache::forget('generalContact'.$contact->id);
            Cache::forget('statusImageShowContact'.$contact->id);
            $contact->images()->detach();
        }

        Contact::whereIn('id', $request->ids)->withTrashed()->forceDelete();
        return response('massRemove Successfully.', 200);
    }
}