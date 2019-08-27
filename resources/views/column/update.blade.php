@extends('layouts.app')

@section('body')

    <link rel="stylesheet" href="/admin/css/pintuer.css">
    <link rel="stylesheet" href="/admin/css/admin.css">
    <link rel="stylesheet" href="{{asset('layui/layui.js')}}">
    <link rel="stylesheet" href="{{asset('layui/layui.css')}}">
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script src="/admin/js/jquery.js"></script>
    <script src="/admin/js/pintuer.js"></script>
    <body>
    <div class="panel admin-panel">
        <input type="hidden" name="c_id" id="c_id" value="{{$res->c_id}}">
        <div class="body-content">
            <div  class="form-x">
                <div class="form-group">
                    <div class="label">
                        <label>栏目名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50"  name="c_name" id="c_name" value="{{$res->c_name}}"  />
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>导航栏名称：</label>
                    </div>
                    <div class="field">
                        <select class="form-control" name="n_id" id="n_id">
                            <option value="0">请选择导航栏</option>
                            @foreach($info as $v)
                                <option value="{{$v->n_id}}" @if($res->n_id==$v->n_id) selected @endif>{{$v->n_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--                <div class="layui-form-item layui-form-text">--}}
                {{--                    <label class="layui-form-label">文本域</label>--}}
                {{--                    <div class="layui-input-block">--}}
                {{--                        <textarea name="desc" placeholder="请输入内容" class="layui-textarea" id="desc"></textarea>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                <div class="form-group">
                    <div class="label">
                        <label for="exampleInputPassword1">是否展示</label>
                    </div>
                    <div class="field">
                        <input type="radio" name="status" id="status" value="1" @if($res->status==1) checked @endif> 是
                        <input type="radio" name="status" id="status" value="2"> 否
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button class="button bg-main icon-check-square-o" type="button" id="btn"> 修改导航栏</button>
                        <button class="button bg-main icon-check-square-o" type="reset"> 重置</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
    <script>
        $(function(){
            $("#btn").click(function(){
                var c_name = $("#c_name").val();
                var c_id = $("#c_id").val();
                var n_id = $("#n_id :selected").prop('value');
                var status = $("#status:checked").prop('value');
                //console.log(c_name);

                $.post(
                    "/column/doupdate",
                    {c_name:c_name,n_id:n_id,status:status,c_id:c_id},
                    function(res){
                        //console.log(res);
                        if(res.code==1){
                            alert(res.msg);
                            location.href="/column/list";
                        }else{
                            alert(res.msg);
                        }
                    },'json'
                );
            })
        })
    </script>
@endsection
