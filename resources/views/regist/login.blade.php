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
</body>
</html>