<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index()
    {
        $per = Permission::paginate(5);

        return view('admin.permission.index',compact('per'));
    }

    public function create()
    {
        return view('admin.permission.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'per_name'  =>  'required',
            'per_url'  =>  'required'
        ]);

        $input = $request->except('_token');

        $per_name = $input['per_name'];
        $per_url = $input['per_url'];

        $res = Permission::create(['per_name'=>$per_name,'per_url'=>$per_url]);

        if ($res){
            $data = [
                'status'=>0,
                'message'=>'添加成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'添加失败'
            ];
        }
        return $data;


    }



    public function edit(Permission $permission)
    {
        return view('admin.permission.edit',compact('permission'));
    }


    public function update(Request $request, Permission $permission)
    {
        $this->validate($request,[
            'per_name'  =>  'required',
            'per_url'  =>  'required'
        ]);

        $per_name = $request['per_name'];
        $per_url = $request['per_url'];

            $res = $permission->update(['per_name' => $per_name, 'per_url' =>$per_url]);

        if ($res){
            $data = [
                'status'=>0,
                'message'=>'修改成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'修改失败'
            ];
        }

        return $data;
    }

    public function destroy(Permission $permission)
    {
        $del = $permission->delete();
        if ($del)
        {
            $data = [
                'status' => 1,
                'message'   =>  '删除成功！',
            ];
        }else
        {
            $data = [
                'status' => 0,
                'message'   =>  '删除失败！',
            ];
        }
        return $data;
    }
}
