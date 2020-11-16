@extends('admin.layout.main')
@section('title','用户列表')

@section('content')
<div class="x-nav">
          <span class="layui-breadcrumb">
            <a href="">首页</a>
            <a href="">演示</a>
            <a>
              <cite>导航元素</cite></a>
          </span>
    <a class="layui-btn layui-btn-small" style="line-height:1.6em;margin-top:3px;float:right" onclick="location.reload()" title="刷新">
        <i class="layui-icon layui-icon-refresh" style="line-height:30px"></i></a>
</div>
<div class="layui-fluid">
    <div class="layui-row layui-col-space15">
        <div class="layui-col-md12">
            <div class="layui-card">
                <div class="layui-card-body ">
                    <form class="layui-form layui-col-space5" action="{{ route('admin.admin.index') }}" method="get">
                        <div class="layui-inline layui-show-xs-block">
                            <input type="text" name="username" value="{{ $request->input('username') }}" placeholder="请输入管理员名" autocomplete="off" class="layui-input">
                        </div>
                        <div class="layui-inline layui-show-xs-block">
                            <button class="layui-btn"  lay-submit="" lay-filter="sreach"><i class="layui-icon">&#xe615;</i></button>
                        </div>
                    </form>
                </div>
                <div class="layui-card-header">
                    <button class="layui-btn" onclick="xadmin.open('添加用户','{{ route('admin.admin.create') }}',600,400)"><i class="layui-icon"></i>添加</button>
                </div>

                @include('shared._messages')

                <div class="layui-card-body layui-table-body layui-table-main">
                    <table class="layui-table layui-form">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>姓名</th>
                            <th>创建日期</th>
                            <th>修改日期</th>
                            <th>状态</th>
                            <th>操作</th></tr>
                        </thead>
                        <tbody>
                        @foreach($admin as $u)
                            @csrf
                        <tr>
                            <td>{{ $u->id }}</td>
                            <td>{{ $u->username }}</td>
                            <td>{{ $u->created_at }}</td>
                            <td>{{ $u->updated_at }}</td>
                            <td class="td-status">
                                <span class="layui-btn layui-btn-normal layui-btn-mini">已启用</span></td>
                            <td class="td-manage">
                                <a onclick="member_stop(this,'10001')" href="javascript:;"  title="启用">
                                    <i class="layui-icon">&#xe601;</i>
                                </a>
                                <a title="编辑"  onclick="xadmin.open('编辑','{{ route('admin.admin.edit',$u) }}',600,400)" href="javascript:;">
                                    <i class="layui-icon">&#xe642;</i>
                                </a>

                                <a title="授权" href="{{ route('admin.admin.auth',$u) }}">
                                    <i class="layui-icon">&#xe612;</i>
                                </a>

                                <a title="删除" url="{{ route('admin.admin.destroy',$u->id) }}" onclick="member_del(this,{{ $u->id }})" href="javascript:;">
                                    <i class="layui-icon">&#xe640;</i>
                                </a>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="layui-card-body ">
                    <div class="page">
                        {{ $admin->appends($request->all())->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    layui.use(['laydate','form'], function(){
        var laydate = layui.laydate;
        var  form = layui.form;


        // 监听全选
        form.on('checkbox(checkall)', function(data){

            if(data.elem.checked){
                $('tbody input').prop('checked',true);
            }else{
                $('tbody input').prop('checked',false);
            }
            form.render('checkbox');
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#start' //指定元素
        });

        //执行一个laydate实例
        laydate.render({
            elem: '#end' //指定元素
        });


    });

    /*用户-停用*/
    function member_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){

            if($(obj).attr('title')=='启用'){

                //发异步把用户状态进行更改
                $(obj).attr('title','停用')
                $(obj).find('i').html('&#xe62f;');

                $(obj).parents("tr").find(".td-status").find('span').addClass('layui-btn-disabled').html('已停用');
                layer.msg('已停用!',{icon: 5,time:1000});

            }else{
                $(obj).attr('title','启用')
                $(obj).find('i').html('&#xe601;');

                $(obj).parents("tr").find(".td-status").find('span').removeClass('layui-btn-disabled').html('已启用');
                layer.msg('已启用!',{icon: 5,time:1000});
            }

        });
    }

    /*用户-删除*/
    function member_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            var url = $(obj).attr('url');
            //发异步删除数据
            $.ajax({
                type:"DELETE",
                url,
                dataType:'json',
                headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' },
                success:function(data) {
                    if (data.status == 1){
                        $(obj).parents("tr").remove();
                        // xadmin.father_reload();
                        layer.msg(data.message,{icon:1,time:1000});
                    }
                }
            })

        });
    }



    function delAll (argument) {
        var ids = [];

        // 获取选中的id
        $('tbody input').each(function(index, el) {
            if($(this).prop('checked')){
                ids.push($(this).val())
            }
        });

        layer.confirm('确认要删除吗？'+ids.toString(),function(index){
            //捉到所有被选中的，发异步进行删除
            layer.msg('删除成功', {icon: 1});
            $(".layui-form-checked").not('.header').parents('tr').remove();
        });
    }
</script>

@endsection