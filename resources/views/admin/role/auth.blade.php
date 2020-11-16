@extends('admin.layout.main')
@section('title','角色分配')

@section('content')
    <div class="layui-fluid">
        <div class="layui-row">
            <form class="layui-form" action="{{ route('admin.role.doAuth') }}" method="post">

                @csrf
                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>角色名称</label>
                    <div class="layui-input-inline">
                        <input type="hidden" value="{{ $role->id }}" name="role_id" id="role_id">
                        <input type="text" id="L_rolename" name="role_name" value="{{ $role->role_name }}"  required="" lay-verify="text" autocomplete="off" class="layui-input"></div>


                <div class="layui-form-item">
                    <label for="L_email" class="layui-form-label">
                        <span class="x-red">*</span>角色权限</label>
                    <div class="layui-input-inline" >
                        @foreach($perms as $p)
                            @if(in_array($p->id,$own_pers))
                                <input type="checkbox" name="permission_id[]" title="{{ $p->per_name }}" value="{{ $p->id }}" lay-skin="primary" checked>
                            @else
                                <input type="checkbox" name="permission_id[]" title="{{ $p->per_name }}" value="{{ $p->id }}" lay-skin="primary">
                            @endif
                        @endforeach
                    </div>
                </div>


                <div class="layui-form-item">
                    <label for="L_repass" class="layui-form-label"></label>
                    <button class="layui-btn" lay-filter="add" lay-submit="">授权</button></div>
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
                {{--form.on('submit(add)',--}}
                    {{--function(data) {--}}
                        {{--// console.log(data);--}}
                        {{--var role_id = $('#role_id').val();--}}
                        {{--var permission_id = $("input[name='permission_id']:checked").val();--}}
                        {{--//发异步，把数据提交给php--}}
                        {{--$.ajax({--}}
                            {{--type:'POST',--}}
                            {{--dataType:'json',--}}
                            {{--headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },--}}
                            {{--url:"{{ route('admin.role.doAuth') }}",--}}
                            {{--data:{--}}
                                {{--'role_id':role_id,--}}
                                {{--'permission_id':permission_id,--}}
                            {{--},--}}
                            {{--success:function(data){--}}
                                {{--if (data.status == 0){--}}
                                    {{--layer.alert(data.message,{icon:1},function () {--}}
                                        {{--xadmin.close();--}}
                                        {{--xadmin.father_reload();--}}
                                    {{--})--}}
                                {{--}--}}
                            {{--},--}}
                            {{--error:function (msg) {--}}
                                {{--var json=JSON.parse(msg.responseText);--}}
                                {{--$.each(json.errors, function(idx, obj) {--}}
                                    {{--alert(obj[0]);--}}
                                    {{--return false;--}}
                                {{--});--}}
                            {{--}--}}
                        {{--});--}}
                        {{--return false;--}}
                    {{--});--}}

            });
    </script>

@endsection