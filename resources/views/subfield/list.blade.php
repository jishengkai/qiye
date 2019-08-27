@extends('layouts.app')

@section('body')
<link rel="stylesheet" href="{{asset('layui/layui.js')}}">
<link rel="stylesheet" href="{{asset('layui/layui.css')}}">

<form >
    <input type="text" placeholder="请输入搜索关键字" name="s_name"   class="input" style="width:250px; line-height:17px;display:inline-block" />
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
        <th>分栏名称</th>
        <th>所属栏目</th>
        <th>创建时间</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    @foreach ($res as $v)
    <tbody>
    <tr>
        <td>{{$v->s_id}}</td>
        <td>{{$v->s_name}}</td>
        <td>{{$v->c_name}}</td>
        <td>{{date("Y-m-d h:i:s" , $v->create_time)}}</td>
        <td>@if($v->status ==1)
            显示
                @elseif($v->status==2)
            不显示
                @endif
        </td>
        <td><a href="javascript:;" class="del" s_id='{{$v->s_id}}'>删除</a>||<a href="/subfield/update?id={{$v->s_id}}">修改</a></td>
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
          var s_id=_this.attr('s_id');
          //console.log(n_id);
          $.post(
              "/subfield/del",
              {s_id:s_id},
              function(res){
                  // console.log(res);
                  if(res.code==1 ){
                      var f=confirm("确定要删除吗？");
                      if(f == true){
                          location.href='/subfield/list';
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