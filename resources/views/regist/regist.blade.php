<!doctype html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <title>注册</title>
</head>
<body>
        <h3>欢迎注册</h3>
        <hr>
        <form action="/registdo" method="post">
            @csrf
            <input type="text" name="user_name" placeholder="请输入用户名">
            <br>
            <input type="password" name="pass1" placeholder="请输入密码">
            <br>
            <input type="password" name="pass2" placeholder="请确认密码">
            <br>
            <input type="email" name="email" placeholder="请输入邮箱">
            <br>
            <input type="submit" value="确定注册">
        </form>
</body>
</html>