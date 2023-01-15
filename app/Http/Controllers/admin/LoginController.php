<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('admin.auth.login');

    }

    public function postLogin(Request $request)
    {
        if ($request->has('submit')) {

            $validator = $request->validate([
                'email' => 'required|email',
                'password'=>'required',
            ]);

            if(Auth::attempt($validator,$request->remember)) {

                $request->session()->regenerate();
                Auth::user();
                return redirect()->intended('admin/dashboard');
            }
            else {
                return redirect()->back()->with('error','The provided credentials do not match our records');
            }
        }
        else {
            return redirect()->back();
        }

    }
}
