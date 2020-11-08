<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{

    public function index()
    {

        $users = User::orderBy('created_at','desc')->paginate(5);
        return view('admin.users.index',compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(UsersRequest $request)
    {
        $input = $request->except('_token');
        $data['name'] = $input['name'];
        $data['password'] = bcrypt($input['password']);
        $data['email'] = $input['email'];


        $users = User::create($data);
        if ($users)
        {
            $data = [
                'status' => 1,
                'message'   =>  '添加成功！',
            ];
        }else
        {
            $data = [
                'status' => 0,
                'message'   =>  '添加失败！',
            ];
        }

        return $data;

    }

    public function show($id)
    {
        //
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
            $user->update(['name' => $name]);
        }else{
            $user->update(['name' => $name, 'password' => bcrypt($password)]);
        }

        session()->flash('success','修改成功');
        return $data = ['status' => 1];
    }

    public function destroy(User $user)
    {
        $user->delete();
        session()->flash('success','删除成功');
        return $data = ['status' => 1];
    }
}
