@extends('layouts.app')

@section('body')

<link rel="stylesheet" href="{{asset('layui/layui.js')}}">
<link rel="stylesheet" href="{{asset('layui/layui.css')}}">
<h1 align="center"> 头部轮播图</h1>
<form >
    <input type="text" placeholder="请输入搜索关键字" name="m_name"   class="input" style="width:250px; line-height:17px;display:inline-block" />
    {{--    <input type="submit" class="button border-main icon-search">--}}
    <button  class="button border-main icon-search">搜索</button>
</form>
<table class="layui-table" align="center" >
    <colgroup>
        <col width="150">
        <col width="200">
        <col>
    </colgroup>
    <thead>
    <tr>
        <th>ID</th>
        <th>轮播图名称</th>
        <th>图片</th>
        <th>权重</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    @foreach ($res as $v)
        <tbody>
        <tr>
            <td>{{$v->m_id}}</td>
            <td>{{$v->m_name}}</td>
            <td><img src="/uploads/{{$v->img}}" alt=""></td>
            <td>{{$v->weight}}</td>
            <td>@if($v->status ==1)
                    显示
                @elseif($v->status==2)
                    不显示
                @endif
            </td>
            <td><a href="javascript:;" class="del" m_id='{{$v->m_id}}'>删除</a></td>
        </tr>
        </tbody>
    @endforeach
</table>
<div align="center">
    {{$res->appends($query)->links()}}
</div>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script>
    $(function(){
        $(".del").click(function(){
            var _this=$(this);
            var m_id=_this.attr('m_id');
            //console.log(m_id);
            $.post(
                "/rmap/del",
                {m_id:m_id},
                function(res) {
                    //console.log(res);
                        if(res.code==1 ){
                            var f=confirm("确定要删除吗？");
                            if(f == true){
                                location.href='/rmap/list';
                            }
                        }else{
                            alert(res.msg);
                        }
                    },'json'

            );
        })
    })
</script>



{{--<link rel="stylesheet" href="{{asset('layui/layui.js')}}">--}}
{{--<link rel="stylesheet" href="{{asset('layui/layui.css')}}">--}}
{{--<h1 align="center"> 底部轮播图</h1>--}}
{{--<table class="layui-table" align="center" >--}}
{{--    <colgroup>--}}
{{--        <col width="150">--}}
{{--        <col width="200">--}}
{{--        <col>--}}
{{--    </colgroup>--}}
{{--    <thead>--}}
{{--    <tr>--}}
{{--        <th>ID</th>--}}
{{--        <th>轮播图名称</th>--}}
{{--        <th>图片</th>--}}
{{--        <th>权重</th>--}}
{{--        <th>状态</th>--}}
{{--        <th>操作</th>--}}
{{--    </tr>--}}
{{--    </thead>--}}
{{--    @foreach ($res as $v)--}}
{{--        <tbody>--}}
{{--        <tr>--}}
{{--            <td>{{$v->m_id}}</td>--}}
{{--            <td>{{$v->m_name}}</td>--}}
{{--            <td><img src="/uploads/{{$v->img}}" alt=""></td>--}}
{{--            <td>{{$v->weight}}</td>--}}
{{--            <td>@if($v->status ==1)--}}
{{--                    显示--}}
{{--                @elseif($v->status==2)--}}
{{--                    不显示--}}
{{--                @endif--}}
{{--            </td>--}}
{{--            <td><a href="javascript:;" class="del" m_id='{{$v->m_id}}'>删除</a></td>--}}
{{--        </tr>--}}
{{--        </tbody>--}}
{{--    @endforeach--}}
{{--</table>--}}
{{--<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>--}}
{{--<script>--}}
{{--    $(function(){--}}
{{--        $(".del").click(function(){--}}
{{--            var _this=$(this);--}}
{{--            var m_id=_this.attr('m_id');--}}
{{--            //console.log(m_id);--}}
{{--            $.post(--}}
{{--                "/rmap/del",--}}
{{--                {m_id:m_id},--}}
{{--                function(res) {--}}
{{--                    console.log(res);--}}
{{--                    //     if(res.code==1 ){--}}
{{--                    //         var f=confirm("确定要删除吗？");--}}
{{--                    //         if(f == true){--}}
{{--                    //             location.href='/rmap/list';--}}
{{--                    //         }--}}
{{--                    //     }else{--}}
{{--                    //         alert(res.msg);--}}
{{--                    //     }--}}
{{--                    // },'json'--}}
{{--                }--}}
{{--            );--}}
{{--        })--}}
{{--    })--}}
{{--</script>--}}


@endsection
