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
        <input type="hidden" id="s_id" name="s_id" value="{{$res->s_id}}">
        <div class="body-content">
            <div  class="form-x">
                <div class="form-group">
                    <div class="label">
                        <label>分栏名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50"  name="s_name" id="s_name"  value="{{$res->s_name}}"/>
                        <div class="tips"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label>栏目名称：</label>
                    </div>
                    <div class="field">
                        <select class="form-control" name="n_id" id="s_id">
                            <option value="0">请选择栏目</option>
                            @foreach($info as $v)
                                <option value="{{$v->c_id}}" @if($res->s_id==$v->c_id) selected @endif>{{$v->c_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="desc" >
                    <label>描述：</label>
                    <div id="editor" >
                        <p>{{$res->desc}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label for="exampleInputPassword1">是否展示</label>
                    </div>
                    <div class="field">
                        <input type="radio" name="status" id="status" value="1" @if($res->status==1) checked @endif> 是
                        <input type="radio" name="status" id="status" value="2" @if($res->status==2) checked @endif> 否
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button class="button bg-main icon-check-square-o" type="button" id="btn"> 修改分栏</button>
                        <button class="button bg-main icon-check-square-o" type="reset"> 重置</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </body>
    <!-- 注意， 只需要引用 JS，无需引用任何 CSS ！！！-->
    <script type="text/javascript" src="/wangEditor-3.1.1/Editor/release/wangEditor.min.js"></script>
    <script type="text/javascript">
        var E = window.wangEditor
        var editor = new E('#editor')
        // 或者 var editor = new E( document.getElementById('editor') )
        editor.create()
    </script>

    <script>
        $(function(){
            $("#btn").click(function(){
                var s_name = $("#s_name").val();
                var s_id = $("#s_id").val();
                // var desc = $("#desc").val();
                var c_id = $("#c_id :selected").prop('value');
                var status = $("#status:checked").prop('value');
                var desc = $(".desc").children("div").text();
                //console.log(c_name);

                $.post(
                    "/subfield/doupdate",
                    {s_name:s_name,c_id:c_id,status:status,desc:desc,s_id:s_id},
                    function(res){
                        //console.log(res);
                        if(res.code==1){
                            alert(res.msg);
                            location.href="/subfield/list";
                        }else{
                            alert(res.msg);
                        }
                    },'json'
                );
            })
        })
    </script>
@endsection

