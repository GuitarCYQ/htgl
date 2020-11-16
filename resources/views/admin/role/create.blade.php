@extends('admin.layout.main')
@section('title','角色添加')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form" action="" method="">

                @csrf
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>角色名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_rolename" name="role_name" required="" lay-verify="text" autocomplete="off" class="layui-input"></div>
                    <div class="layui-form-mid layui-word-aux">
                        <span class="x-red">*</span>请输入角色名称</div></div>


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

                // //自定义验证规则
                // form.verify({
                //     nikename: function(value) {
                //         if (value.length < 3) {
                //             return '昵称至少得3个字符啊';
                //         }
                //     },
                //
                // });

                //监听提交
                form.on('submit(add)',
                    function(data) {
                        // console.log(data);
                        var role_name = $('#L_rolename').val();
                        //发异步，把数据提交给php
                        $.ajax({
                            type:'POST',
                            dataType:'json',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            url:"{{ route('admin.role.store') }}",
                            data:{
                                'role_name':role_name,

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