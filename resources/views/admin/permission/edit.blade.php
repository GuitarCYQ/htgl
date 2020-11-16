@extends('admin.layout.main')
@section('title','权限修改')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form" action="" method="">
                <input type="hidden" name="_method" value="PUT">
                @csrf

                <div class="layui-form-item">
                    <label for="L_per" class="layui-form-label">
                        <span class="x-red">*</span>权限名称</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_pername" name="per_url" required="" lay-verify="nikename" value="{{ $permission['per_name'] }}" autocomplete="off" class="layui-input"></div>
                </div>

                <div class="layui-form-item">
                    <label for="L_per" class="layui-form-label">
                        <span class="x-red">*</span>权限路由</label>
                    <div class="layui-input-inline">
                        <input type="text" id="L_perurl" name="per_url" required="" lay-verify="nikename" value="{{ $permission['per_url'] }}" autocomplete="off" class="layui-input"></div>
                </div>

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



                //监听提交
                //监听提交
                form.on('submit(edit)',
                    function(data) {
                        var per_name = $('#L_pername').val();
                        var per_url = $('#L_perurl').val();
                        $.ajax({
                            type:'PUT',
                            dataType:'json',
                            headers:{
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url:"{{ route('admin.permission.update',$permission->id) }}",
                            data:{
                                'per_name':per_name,
                                'per_url' : per_url,
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