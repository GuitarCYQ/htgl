<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    public function index(Request $request)
    {
        //获取搜索提交的参数
//        $input = $request->all();
//        dd($input);

        $users = User::orderBy('id','asc')
            ->where(function ($query) use ($request){
                $name = $request->input('name');
                $email = $request->input('email');
                if(!empty($name)){
                    $query->where('name','like','%'.$name.'%');
                }
                if(!empty($email)){
                    $query->where('created_at','like','%'.$email.'%');
                }
            })
            ->paginate(10);

        return view('admin.users.index',compact('users','request'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UsersRequest $request)
    {
        $input = $request->except('_token');

        $name = $input['name'];
        $email = $input['email'];
        $password = Crypt::encrypt($input['password']);

        $res = User::create(['name'=>$name,'password'=>$password,'email'=>$email]);

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



    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $this->validate($request,[
            'name'  =>  'required|between:3,18',
//            'password'  =>  'between:3,17'
        ]);

        $name = $request['name'];
        $password = $request['password'];

        if (trim($password) == '')
        {
            $res = $user->update(['name' => $name]);
        }else{
            $res = $user->update(['name' => $name, 'password' => bcrypt($password)]);
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

    public function destroy(User $user)
    {
        $del = $user->delete();
//        session()->flash('success','删除成功');
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

    public function delAll(Request $request)
    {
        $input = $request->input('ids');

        $res = User::destroy($input);
        if ($res){
            $data = [
                'status'=>0,
                'message'=>'删除成功'
            ];
        }else{
            $data = [
                'status'=>1,
                'message'=>'删除失败'
            ];
        }
        return $data;
    }
}
