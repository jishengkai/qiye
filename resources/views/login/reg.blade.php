
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>注册页面</title>
    <link type="text/css" rel="stylesheet" href="/css/css.css"/>
</head>
<body>
<div align="center">
    <table  >
        <tr>
            <td>
                用&nbsp;户&nbsp;名:<input type="text" id="uname" name="uname" />
            </td>
            <td class="right">
                <span ><p id="un"> </p></span>
            </td>
        </tr>

        <tr>
            <td>
                设置密码:<input type="password" id="pwd" name="pwd"/>
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
                手&nbsp;机&nbsp;&nbsp;号:<input type="text" id="tel" name="tel"/>
            </td>
            <td class="right">
                <span><p id="p3"> </p></span>
            </td>
        </tr>

        <tr>
            <td>
                邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱:&nbsp;&nbsp;<input type="text" id="email" name="email"/>
            </td>
            <td class="right">
                <span><p id="ma"> </p></span>
            </td>
        </tr>

{{--        <tr>--}}
{{--            <td>--}}
{{--                验证码:<input type="text" id="code" name="code"/>--}}
{{--            </td>--}}
{{--            <td class="right">--}}
{{--                <span><p id="p2"> </p></span>--}}
{{--            </td>--}}
{{--        </tr>--}}

        <tr>
            <td>
                <input id="btn" type="button" value="提交" />&nbsp;&nbsp;&nbsp;&nbsp;

                <input id="reset" type="reset" value="重置">
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
        $('#btn').click(function(){
            var uname=$('#uname').val();
            var pwd=$('#pwd').val();
            var repwd=$('#repwd').val();
            var email=$('#email').val();
            var code=$('#code').val();
            var tel=$('#tel').val();
            // console.log(uname);

            if(uname==''){
                alert('用户名不能为空');
                return false;
            }

            if(pwd==''){
                alert('密码不能为空');
                return false;
            }

            if(repwd==''){
                alert('确认密码不能为空');
                return false;
            }else if(pwd !=repwd){
                alert('密码与确认密码不一致');
                return false;
            }


            if(email==''){
                alert('邮箱不能为空');
                return false;
            }

            // if(code==''){
            //     alert('验证码不能为空');
            //     return false;
            // }

            if(tel==''){
                alert('手机号不能为空');
                return false;
            }

            $.post({
                url:"/login/regdo",
                data:{uname:uname,pwd:pwd,repwd:repwd,email:email},
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