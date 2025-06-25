<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Data;
use App\Models\Person;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
	public function index() {
//        $users = User::count();
//        $subscribers = Subscriber::count();
//        $articles = Article::count();
//        $persons = Person::count();
//        $verdicts = Verdict::count();
//        $data = Data::count();
//        return view('backend.index', compact('users', 'subscribers', 'articles', 'persons', 'verdicts', 'data'));
        return view('backend.dashboard.index');

    }

	public function logout(): \Illuminate\Http\RedirectResponse
    {
		Session::flush();
        Auth::logout();
        return redirect()->route('frontend.index');
	}
}
