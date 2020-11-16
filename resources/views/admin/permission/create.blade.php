@extends('admin.layout.main')
@section('title','权限添加')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form" action="" method="">

                @csrf
                <div class="layui-form-item">
                    <label for="L_per" class="layui-form-label">
                        <span class="x-red">*</span>权限名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_pername" name="per_url" required="" lay-verify="nikename" autocomplete="off" class="layui-input"></div>
                </div>

                <div class="layui-form-item">
                    <label for="L_per" class="layui-form-label">
                        <span class="x-red">*</span>权限路由</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_perurl" name="per_url" required="" lay-verify="nikename" autocomplete="off" class="layui-input"></div>
                </div>

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


                //监听提交
                form.on('submit(add)',
                    function(data) {
                        // console.log(data);
                        var per_name = $('#L_pername').val();
                        var per_url = $('#L_perurl').val();
                        //发异步，把数据提交给php
                        $.ajax({
                            type:'POST',
                            dataType:'json',
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            url:"{{ route('admin.permission.store') }}",
                            data:{
                                'per_name':per_name,
                                'per_url' : per_url,
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