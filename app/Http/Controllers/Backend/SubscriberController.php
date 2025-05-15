<?php

namespace App\Http\Controllers\Backend;

use App\DataTables\SubscribersDataTable;
use App\DataTables\SubscribersDataTableTrash;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Subscriber;
use Gate;

class SubscriberController extends Controller
{

    public function index(SubscribersDataTable $dataTable){
        Gate::authorize('backend.subscribers.index');
        return $dataTable->render('backend.subscribers.index');
    }

    public function destroy($lang, $id)
    {
        Gate::authorize('backend.subscribers.destroy');
        $subscriber = Subscriber::find($id)->delete();
        return redirect()->route('backend.subscribers.index', app()->getLocale())
            ->with('success', __('strings.Deleted Successfully'));
    }

    public function trash(SubscribersDataTableTrash $dataTable){
        Gate::authorize('backend.subscribers.trash');
        return $dataTable->render('backend.subscribers.trash');
    }

    public function restore(Request $request)
    {
        Gate::authorize('backend.subscribers.restore');
        $subscriber = Subscriber::where('id', $request->id)->withTrashed()->first();
        $subscriber->restore();
        $subscriber->fresh();
        return redirect()->route('backend.subscribers.trash', app()->getLocale())
            ->with('success', __('strings.Restored Successfully'));
    }

    public function remove(Request $request)
    {
        Gate::authorize('backend.subscribers.remove');
        $subscriber = Subscriber::where('id', $request->id)->withTrashed()->first();
        $subscriber->forceDelete();
        $subscriber->fresh();
        return redirect()->route('backend.subscribers.trash', app()->getLocale())
            ->with('success', __('strings.Deleted Successfully from Archive'));
    }
}

