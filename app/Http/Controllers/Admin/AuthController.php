<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class AuthController extends Controller
{
    //
    public function index()
    {
        return view('Admin.index');
    }

    public function login(AdminLoginPostRequest $request)
    {
        $datum = $request->validated();
        //ddd($datum);

        if(Auth::guard('admin')->attempt($datum) === false)
        {
            return back()
                    ->withInput()
                    ->withErrors(['auth'=>'ログインIDかパスワードに誤りがあります。',]);
        }


        $request->session()->regenerate();
        return redirect()->intended('/admin/top');

    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->regenerateToken();
        $request->session()->regenerate();
        return redirect(route('admin.index'));
    }
}
