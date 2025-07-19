<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Data;
use App\Models\Person;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index() {
        return view('backend.dashboard.index');
    }
    public function analytics() {
        return view('backend.dashboard.analytics');
    }
	public function logout(): \Illuminate\Http\RedirectResponse
    {
		Session::flush();
        Auth::logout();
        return redirect()->route('frontend.index');
	}
}
