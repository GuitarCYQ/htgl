@extends('admin.layout.main')
@section('title','用户修改')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form" action="{{ route('admin.users.update',$user->id) }}" method="post">
                <input type="hidden" name="_method" value="PUT">
                @csrf

                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" disabled value="{{ old('email',$user->email) }}" required="" lay-verify="email" autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名</div></div>
                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>昵称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_username" name="name" value="{{ old('name',$user->name) }}" required="" lay-verify="nikename" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码</label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="password"  autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">6到16个字符</div></div>
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="edit" lay-submit="">修改</button></div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>layui.use(['form', 'layer','jquery'],
            function() {
                $ = layui.jquery;
                var form = layui.form,
                    layer = layui.layer;

                //自定义验证规则
                form.verify({
                    nikename: function(value) {
                        if (value.length < 3) {
                            return '昵称至少得3个字符啊';
                        }
                    },

                });

                //监听提交
                //监听提交
                form.on('submit(edit)',
                    function(data) {
                        var name = $('#L_username').val();
                        var password = $('#L_pass').val();
                        var email = $('#L_email').val();
                        $.ajax({
                            type:'PUT',
                            dataType:'json',
                            headers:{
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url:"{{ route('admin.users.update',$user->id) }}",
                            data:{
                                'name':name,
                                'password':password,
                                'email':email,
                            },
                            success:function (data) {
                                //弹层提示添加成功，并刷新页面
                                if (data.status == 0){
                                    layer.alert(data.message,{icon:1},function () {
                                        // parent.location.reload(true);
                                        //关闭当前frame
                                        xadmin.close();
                                        // 可以对父窗口进行刷新
                                        xadmin.father_reload();
                                    })
                                }else{
                                    layer.alert(data.message,{icon: 2});
                                }
                            },
                            error:function (msg) {
                                var json=JSON.parse(msg.responseText);
                                $.each(json.errors, function(idx, obj) {
                                    alert(obj[0]);
                                    return false;
                                });
                            }
                        });
                        return false;
                    });

            });</script>

@endsection