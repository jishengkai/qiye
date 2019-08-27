@extends('layouts.app')

@section('body')

    <link rel="stylesheet" href="/admin/css/pintuer.css">
    <link rel="stylesheet" href="/admin/css/admin.css">
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script src="/admin/js/jquery.js"></script>
    <script src="/admin/js/pintuer.js"></script>
    <body>
    <div class="panel admin-panel">
        <div class="panel-head" id="add"><strong><span class="icon-pencil-square-o"></span>增加内容</strong></div>
        <div class="body-content">
            <div  class="form-x">
                <input type="hidden" name="n_id" id="n_id" value="{{$res->n_id}}" >
                <div class="form-group">
                    <div class="label">
                        <label>导航名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50"  name="n_name" id="n_name"  value="{{$res->n_name}}" />
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>导航栏权重：</label>
                    </div>
                    <div class="field">
                        <select class="form-control" name="weight" id="weight" >
                            <option >请选择权重等级</option>
                            <option value="1" @if($res->weight==1) selected @endif >1</option>
                            <option value="2" @if($res->weight==2) selected @endif>2</option>
                            <option value="3" @if($res->weight==3) selected @endif>3</option>
                            <option value="4" @if($res->weight==4) selected @endif>4</option>
                        </select>

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
                var n_id=$('#n_id').val();
                var n_name = $("#n_name").val();
                var weight = $("#weight :selected").prop('value');
                var status = $("#status:checked").prop('value');
                // console.log(n_id);return

                $.post(
                    '/navbar/doupdate',
                    {n_name:n_name,weight:weight,status:status,n_id:n_id},
                    function(res) {
                        // console.log(res);
                            if( res.code == 1){
                                alert(res.msg);
                                location.href="/navbar/list";
                            }else{
                                alert(res.msg);
                            }
                        },'json'

                );
            })
        })
    </script>
@endsection

