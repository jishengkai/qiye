@extends('layouts.app')

@section('body')
    <link rel="stylesheet" href="/admin/css/pintuer.css">
    <link rel="stylesheet" href="/admin/css/admin.css">
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script src="/admin/js/jquery.js"></script>
    <script src="/admin/js/pintuer.js"></script>
    <body>
    <form class="form-horizontal" method="POST" action="/rmap/doadd" enctype="multipart/form-data">
    <div class="panel admin-panel">

        <div class="body-content">
            <div  class="form-x">
                <div class="form-group">
                    <div class="label">
                        <label>轮播图名称：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50"  name="m_name" id="m_name" />
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>轮播图图片：</label>
                    </div>
                    <div class="field">
                        <input type="file" class="input w50"  name="img" id="img" />
                        <div class="tips"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label">
                        <label>轮播图权重：</label>
                    </div>
                    <div class="field">
                        <input type="text" class="input w50" name="weight" id="weight">
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label for="exampleInputPassword1">是否展示</label>
                    </div>
                    <div class="field">
                        <input type="radio" name="status" id="status" value="1" checked> 是
                        <input type="radio" name="status" id="status" value="2"> 否
                    </div>
                </div>

                <div class="form-group">
                    <div class="label">
                        <label></label>
                    </div>
                    <div class="field">
                        <button class="button bg-main icon-check-square-o" type="submit" id="btn"> 添加轮播图</button>
                        <button class="button bg-main icon-check-square-o" type="reset"> 重置</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </form>
    </body>

@endsection