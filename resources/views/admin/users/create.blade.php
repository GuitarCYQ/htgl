@extends('admin.layout.main')
@section('title','用户列表')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            @if($errors->any())
                <div class = "Huialert Huialert-error"> <i class = "Hui-iconfont"> x </i>
                    @foreach($errors -> all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
            <form class="layui-form" action="" method="">

                @csrf
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>邮箱</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_email" name="email" required="" lay-verify="email" autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>将会成为您唯一的登入名</div></div>
                <div class="layui-form-item">
                    <label for="L_username" class="layui-form-label">
                        <span class="x-red">*</span>昵称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_username" name="name" required="" lay-verify="nikename" autocomplete="off" class="layui-input"></div>
                </div>
                <div class="layui-form-item">
                    <label for="L_pass" class="layui-form-label">
                        <span class="x-red">*</span>密码</label>
                    <div class="layui-input-inline">
                        <input type="password" id="L_pass" name="password" required="" lay-verify="pass" autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">6到16个字符</div></div>
                {{--<div class="layui-form-item">--}}
                    {{--<label for="L_repass" class="layui-form-label">--}}
                        {{--<span class="x-red">*</span>确认密码</label>--}}
                    {{--<div class="layui-input-inline">--}}
                        {{--<input type="password" id="L_repass" name="password_confirmation" required="" lay-verify="repass" autocomplete="off" class="layui-input"></div>--}}
                {{--</div>--}}
                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">增加</button></div>
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
                form.on('submit(add)',
                    function(data) {
                        // console.log(data);
                        var name = $('#L_username').val();
                        var password = $('#L_pass').val();
                        var email = $('#L_email').val();
                        //发异步，把数据提交给php
                        $.ajax({
                            type:'POST',
                            dataType:'json',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            url:"{{ route('admin.users.store') }}",
                            data:{
                                'name':name,
                                'password' : password,
                                'email' : email
                            },
                            success:function(data){
                                if (data.status == 0){
                                    layer.alert(data.message,{icon:1},function () {
                                        xadmin.close();
                                        xadmin.father_reload();
                                    })
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