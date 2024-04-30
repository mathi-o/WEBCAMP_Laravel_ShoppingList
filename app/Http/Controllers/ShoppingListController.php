<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ListRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping_list as Shopping_listModel;
use Illuminate\Support\Facades\DB;
use App\Models\Completed_shopping_list as Completed_shopping_listModel;

class ShoppingListController extends Controller
{
    //
    public function list()
    {
        $per_page=20;

        $list = Shopping_listModel::where('user_id',Auth::id())
                                    ->orderBy('name','ASC')
                                    ->paginate($per_page);
//$sql = Shopping_listModel::where('user_id', Auth::id())->toSql();
//echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('List.list',['list'=>$list]);
    }

    public function register(ListRegisterPostRequest $request)
    {
        $datum = $request->validated();
        $datum['user_id'] = Auth::id();
        try{
            $r = Shopping_listModel::create($datum);
            //var_dump($r); exit;
        } catch(\Throwable $e){
            echo $e->getMessage();
            exit;
        }
        $request->session()->flash('front.task_register_success', true);
        return redirect('/shopping_list/list');
    }

    protected function getShoppinglistModel($shopping_list_id)
    {
        $shopping_list = Shopping_listModel::find($shopping_list_id);
        if($shopping_list===null)
        {
            return null;
        }
        if($shopping_list->user_id !==Auth::id())
        {
            return null;
        }

        return $shopping_list;
    }

    protected function singleShoppinglistRender($shopping_list_id,$template_name)
    {
        $shopping_list = $this->getShoppinglistModel($shopping_list_id);

        if($shopping_list == null)
        {
            return redirect('/shopping_list/list');
        }
        return view($tamplate_name,['shopping_list'=>$shopping_list]);
    }

    public function delete($shopping_list_id,Request $request)
    {
        $shopping_list = $this->getShoppinglistModel($shopping_list_id);
        if($shopping_list !== null)
        {
            $shopping_list->delete();
        }

        $request->session()->flash('front.task_delete_success',true);
        return redirect('/shopping_list/list');
    }

    public function complete($shopping_list_id, Request $request)
    {
        try{
            DB::beginTransaction();

            $shopping_list = $this->getShoppinglistModel($shopping_list_id);
            if($shopping_list == null)
            {
                throw new \Exception('');
            }
            $shopping_list->delete();
            $dask_datum = $shopping_list->toArray();
            unset($dask_datum['updated_at']);
            $r = Completed_shopping_listModel::create($dask_datum);
            if($r === null)
            {
                throw new \Exception('');
            }


            DB::commit();
            $request->session()->flash('front.task_completed_success',true);
        }catch(\Throwable $e){
            DB::rollBack;
            $request->session()->flash('front.task_completed_failure', true);
        }


        return redirect('shopping_list/list');
    }

}
