@extends('layouts.app')

@section('body')

<link rel="stylesheet" href="{{asset('layui/layui.js')}}">
<link rel="stylesheet" href="{{asset('layui/layui.css')}}">
<form >
    <input type="text" placeholder="请输入搜索关键字" name="nav_name"   class="input" style="width:250px; line-height:17px;display:inline-block" />
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
        <th>导航栏名称</th>
        <th>权重</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    @foreach ($res as $v)
    <tbody>
    <tr>
        <td>{{$v->nav_id}}</td>
        <td>{{$v->nav_name}}</td>
        <td>{{$v->weight}}</td>
        <td>@if($v->status ==1)
            显示
                @elseif($v->status==2)
            不显示
                @endif
        </td>
        <td><a href="javascript:;" class="del" nav_id='{{$v->nav_id}}'>删除</a>||<a href="/navbars/update?id={{$v->nav_id}}">修改</a></td>
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
          var nav_id=_this.attr('nav_id');
          //console.log(n_id);
          $.post(
              "/navbars/del",
              {nav_id:nav_id},
              function(res){
                  // console.log(res);
                  if(res.code==1 ){
                      var f=confirm("确定要删除吗？");
                      if(f == true){
                          location.href='/navbars/list';
                      }
                  }else{
                      alert(res.msg);
                  }
              },'json'
          );
      })
  })
</script>
@endsection