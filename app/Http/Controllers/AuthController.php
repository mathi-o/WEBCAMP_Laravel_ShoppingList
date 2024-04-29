<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    //
    public function index()
    {
        return view('index');
    }

    public function login(LoginPostRequest $request)
    {
        $datum = $request->validated();

        if(Auth::attempt($datum)===false)
        {
            return back()
                    ->withInput()
                    ->withErrors(['auth'=>'emailかパスワードに誤りがあります。']);
        }

        $request->session()->regenerate();
        return redirect()->intended('/shopping_list/list');

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect(route('front.index'));
    }

}
