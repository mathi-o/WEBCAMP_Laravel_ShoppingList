<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    //
    public function index()
    {
        return view ('User.index');
    }
    public function register(UserRegisterPostRequest $request)
    {
        $datum = $request->validated();
        $datum['password'] = Hash::make($datum['password']);
        //ddd($datum);
        $r = UserModel::create($datum);
        $request -> session() -> flash('front.task_register_success',true);
        return redirect('/');
    }

}
