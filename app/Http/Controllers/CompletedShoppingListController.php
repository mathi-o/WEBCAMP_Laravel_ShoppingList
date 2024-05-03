<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ListRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping_list as Shopping_listModel;
use Illuminate\Support\Facades\DB;
use App\Models\Completed_shopping_list as Completed_shopping_listModel;

class CompletedShoppingListController extends Controller
{
    //
    public function list()
    {
        $per_page=5;
        $list = Completed_shopping_listModel::where('user_id',Auth::id())
                                            ->orderBy('name','ASC')
                                            ->orderBy('created_at')
                                            ->paginate($per_page);
        return view('List.completed_list',['list'=>$list]);
    }

}
