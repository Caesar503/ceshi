<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>登录</title>
</head>
<body>
<h3>欢迎登录</h3>
<hr>
<form action="/logindo" method="post">
    @csrf
    <input type="email" name="email" placeholder="请输入邮箱">
    <br>
    <input type="password" name="pass1" placeholder="请输入密码">
    <br>

    <input type="submit" value="确定登录">
</form>
<hr>

<button id="api">点击访问api接口</button>
</body>
</html>
<script src="js/jquery-3.2.1.min.js"></script>
<script>
    $(function(){
        //点击api
        $('#api').click(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var aa = 123123;
            $.ajax({
                    url:"http://api_lumen.1809.com/test_t",
                    data:{aa:aa},
                    type:"post",
                    success:function(res){
                        alert(res);
                    },
                    dataType:'json'
            })
        })
    });
</script>