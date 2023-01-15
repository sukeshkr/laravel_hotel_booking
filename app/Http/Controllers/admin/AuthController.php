<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register()
    {
        return view('admin.auth.register');
    }
    public function postRegister(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|confirmed',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator,'register_error');
        }
        else{
            $user = User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
            ]);

            if($user) {
                Auth::login($user);
                event(new Registered($user));
                return redirect()->route('verification.notice')->with('message','Verification link sent!');
            }
            else {
                return redirect()->back()->with('error','Something went wrong on your Registration');
            }

        }

    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('sucess','Sucessfully Logged out');
    }
    public function postForgot(Request $request)
    {
        $request->validate([
            'email'=>'required|email',
        ]);

        $status= Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
        ? back()->with(['status'=> __($status)])
        : back()->withErrors(['email'=> __($status)]);
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'token'   => 'required',
            'email'   => 'required|email',
            'password'=>'required|confirmed',
        ]);

        $status = Password::reset(

            $request->only('email','password','password_confirmation','token'),
            function($user,$password) {

                $user->forceFill([

                    'password'=> Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('sucess',__($status))
                    : redirect()->back()->withErrors(['email'=>[__($status)]]);
    }
}
