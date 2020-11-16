<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

    public function index(Request $request)
    {
        $role = Role::orderBy('id','asc')
            ->where(function ($query) use ($request){
                $role_name = $request->input('role_name');
                if (!empty($role_name)){
                    $query->where('name','like','%'.$role_name.'%');
                }
            })
            ->paginate(10);
        return view('admin.role.index',compact('role','request'));
    }

    public function create()
    {
        return view('admin.role.create');
    }


    public function store(Request $request)
    {
        $this->validate($request,[
            'role_name' =>  'required|unique:roles',
        ],[
            'role_name.required'    =>  '角色名不能为空',
            'role_name.unique'  =>  '角色重复了',
        ]);

        $role_name = $request['role_name'];

        $res = Role::create(['role_name'=>$role_name]);

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

    //授权页面
    public function auth($id)
    {
        //通过id获取当前角色
        $role = Role::find($id);

        //获取所有的权限列表
        $perms = Permission::get();

        //获取当前角色所拥有的所有权限
        $own_perms = $role->permission;
        //角色拥有权限的id
        $own_pers = [];
        foreach ($own_perms as $v)
        {
            $own_pers[] = $v->id;
        }

        return view('admin.role.auth',compact('role','perms','own_pers'));
    }

    public function doAuth(Request $request)
    {
        $input = $request->except('_token');
//        dd($request->except('_token'));
        //删除当前角色已有的权限
        DB::table('role_permission')->where('role_id',$input['role_id'])->delete();

        if (!empty($input['permission_id'])){
            //添加新授权的权限
            foreach ($input['permission_id'] as $v)
            {
                DB::table('role_permission')->insert(['role_id'=>$input['role_id'],'permission_id'=>$v]);
            }
        }


        return redirect()->route('admin.role.index')->with('success','分配成功');

    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
