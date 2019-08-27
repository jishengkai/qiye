
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>修改密码</title>
    <link type="text/css" rel="stylesheet" href="/css/css.css"/>
</head>
<body>
<div align="center">
    <table  >
        <tr>
            <td>
                手机号:<input type="text" id="tel" name="tel" />
            </td>
            <td class="controls">
                <input type="button" class="btn" value="发送验证码" id="send">
            </td>
        </tr>

        <tr>
            <td>
                验证码:<input type="text" id="code" name="code"/>
            </td>
            <td class="right">
                <span><p id="p2"> </p></span>
            </td>
        </tr>

        <tr>
            <td>
                重置密码:<input type="password" id="pwd" name="pwd"/>
            </td>
            <td class="right">
                <span><p id="p1"> </p></span>
            </td>
        </tr>
        <tr>
            <td>
                确认密码:<input type="password" id="repwd" name="repwd"/>
            </td>
            <td class="right">
                <span><p id="p2"> </p></span>
            </td>
        </tr>

        <tr>
            <td>
                <input id="btn" type="button" value="修改" />
            </td>
            <td class="right">
            </td>
        </tr>
    </table>
</div>
</body>
</html>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script>
    $(function(){
        $('#send').click(function(){
            var tel=$('#tel').val();
            var send=$('#send').val();
            // console.log(tel);return;
            reg=/^1[3456789]\d{9}$/;
            if(tel==''){
                alert("手机号不能为空");
                return false;
            }else if(!(reg.test(tel))){
                alert("手机号格式有误");
                return false;
            }

            $.post({
                url:"/login/send",
                data:{tel:tel},
                dataType:'json',
                success:function(res){
                    console.log(res);
                }
            });

            function daojishi(seconds,obj) {
                if (seconds > 1) {
                    seconds--;
                    $(obj).val(seconds + "秒后可重新获取 ").attr("disabled", true);//禁用按钮
                    // 定时1秒调用一次
                    setTimeout(function () {
                        daojishi(seconds, obj);
                    }, 1000);
                } else {
                    $(obj).val("免费获取验证码").attr("disabled", false);//启用按钮
                }
            }
        });

        $('#btn').click(function(){
            var tel=$('#tel').val();
            var pwd=$('#pwd').val();
            var repwd=$('#repwd').val();
            var code=$('#code').val();
            reg=/^1[3456789]\d{9}$/;
            // console.log(tel);return;

            if(tel==''){
                alert("手机号不能为空");
                return false;
            }else if(!(reg.test(tel))){
                alert("手机号格式有误");
                return false;
            }

            if(code==''){
                alert('验证码不能为空');
                return false;
            }

            if(pwd==''){
                alert('重置密码不能为空');
                return false;
            }

            if(repwd==''){
                alert('确认密码不能为空');
                return false;
            }else if(pwd !=repwd){
                alert('重置密码与确认密码不一致');
                return false;
            }

            $.post({
                url:"/login/forgotpwd",
                data:{tel:tel,code:code,pwd:pwd,repwd:repwd},
                dataType:'json',
                success:function(res){
                    // console.log(res);
                    if(res.code==1){
                        alert(res.msg);
                        location.href="/login/login";
                    }else{
                        alert(res.msg);
                    }

                }
            })

        })
    })
</script>
