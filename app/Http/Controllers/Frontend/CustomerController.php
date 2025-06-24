<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
	public function index() {
        return view('frontend.customer.index');

    }

	public function logout(Request $request): \Illuminate\Http\RedirectResponse
    {
		//Session::flush();
        Auth::guard('customers')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.index');
	}
}
