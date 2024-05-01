<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminLoginPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Completed_shopping_list;
use App\Models\User;

class UserController extends Controller
{
    //
    public function list()
    {
        $group_by_column=['users.id','users.name'];
        $list = User::select($group_by_column)
                                ->selectRaw('count(completed_shopping_lists.id) AS completed_shopping_list_num')
                                ->leftJoin('completed_shopping_lists','users.id','=','completed_shopping_lists.user_id')
                                ->groupBy($group_by_column)
                                ->orderBy('users.id')
                                ->get();
       return view ('Admin.list',['users'=>$list]);
    }



}
