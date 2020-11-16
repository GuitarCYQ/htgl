<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        //获取搜索提交的参数
//        $input = $request->all();
//        dd($input);

        $admin = Admin::orderBy('id','asc')
            ->where(function ($query) use ($request){
                $username = $request->input('username');
                if(!empty($username)){
                    $query->where('name','like','%'.$username.'%');
                }
            })
            ->paginate(5);

        return view('admin.admin.index',compact('admin','request'));
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'username'  =>  'required|between:3,18',
            'password'  =>  'required|between:3,18'
        ]);

        $input = $request->except('_token');

        $username = $input['username'];
        $password = Crypt::encrypt($input['password']);

        $res = Admin::create(['name'=>$username,'password'=>$password]);

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
        //通过id获取当前管理员
        $admin = Admin::find($id);

        //获取所有的角色列表
        $role = Role::get();

        //获取当前管理员所拥有的所有角色
        $own_perms = $admin->role;
        //角色拥有权限的id
        $own_pers = [];
        foreach ($own_perms as $v)
        {
            $own_pers[] = $v->id;
        }

        return view('admin.admin.auth',compact('admin','role','own_pers'));
    }

    public function doAuth(Request $request)
    {
        $input = $request->except('_token');
//        dd($request->except('_token'));
        //删除当前角色已有的权限
        DB::table('admin_role')->where('admin_id',$input['admin_id'])->delete();

        if (!empty($input['role_id'])){
            //添加新授权的权限
            foreach ($input['role_id'] as $v)
            {
                DB::table('admin_role')->insert(['admin_id'=>$input['admin_id'],'role_id'=>$v]);
            }
        }


        return redirect()->route('admin.admin.index')->with('success','分配成功');

    }


    public function edit(Admin $admin)
    {
        return view('admin.admin.edit',compact('admin'));
    }


    public function update(Request $request, Admin $admin)
    {
        $this->validate($request,[
            'username'  =>  'required|between:3,18',
//            'password'  =>  'between:3,17'
        ]);

        $username = $request['username'];
        $password = $request['password'];

        if (trim($password) == '')
        {
            $res = $admin->update(['name' => $username]);
        }else{
            $res = $admin->update(['name' => $username, 'password' => bcrypt($password)]);
        }

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

    public function destroy(Admin $admin)
    {
        $del = $admin->delete();

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
