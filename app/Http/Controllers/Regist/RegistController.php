<?php

namespace App\Http\Controllers\Regist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\UserApi;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpKernel\Client;
class RegistController extends Controller
{
    public function regist()
    {
        return view("regist/regist");
    }
    public function registdo(Request $request)
    {
//       dd($request->all());
        $username = $request->user_name;
        $email = $request->email;
        //密码
        $pass = $request->pass1;
        $pass2 = $request->pass2;
        if($pass != $pass2){
            header("Refresh:2;url=/regist");
            die("密码不一致");
        }
        $res = UserApi::where('email',$email)->first();
        if($res){
            header("Refresh:2;url=/regist");
            die("邮箱已经存在");
        }
        $data = [
            'username'=>$username,
            'pass'=>password_hash($pass,PASSWORD_DEFAULT),
            'email'=>$email
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);

        //非对称加密
        $public_k = openssl_get_publickey("file://".storage_path("app/keys/rsa_public_key.pem"));
        openssl_public_encrypt($data,$en_data,$public_k);


        $ch = curl_init();
        $url = "http://api_lumen.1809.com/regist";
//        echo "<hr>";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,base64_encode($en_data));
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);

        $result = curl_exec($ch);
        $code = curl_errno($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($code==0){
            header("Refresh:2;url=/login");
            die($result);
        }else{
            header("Refresh:2;url=/regist");
            die($error);
        }
    }
    public function login()
    {
        return view("regist/login");
    }
    public function logindo(Request $request)
    {
        $username = $request->user_name;
        $email = $request->email;
        $pass = $request->pass1;
        $data = [
            'username'=>$username,
            'pass'=>$pass,
            'email'=>$email
        ];
        $data = json_encode($data,JSON_UNESCAPED_UNICODE);

        //非对称加密
        $public_k = openssl_get_publickey("file://".storage_path("app/keys/rsa_public_key.pem"));
        openssl_public_encrypt($data,$en_data,$public_k);
//        echo base64_encode($en_data);
//        echo "<hr>";
        $ch = curl_init();
        $url = "http://api_lumen.1809.com/login";
//        echo $url;
//        echo "<hr>";
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,base64_encode($en_data));
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);

        $result = curl_exec($ch);
        $code = curl_errno($ch);
        $error = curl_error($ch);
//        echo $code;
        curl_close($ch);
        if($code==0){
//            die($result);
            if($result=="登陆成功")
            {
                header("Refresh:2;url=/index");
                die($result);
            }else{
                header("Refresh:2;url=/login");
                die($error);
            }
        }else{
            header("Refresh:2;url=/login");
            die($error);
        }
    }
    public function index()
    {
        $k = 'token_';
        $r = json_decode(Redis::get($k),true);
        $name = $r['name'];
        echo "<h3 align='center'>欢迎登陆<font color='#00ff7f'>".$name."</font></h3>";
    }
    public function test()
    {
        return view('regist.test');
    }
    public function test_t()
    {
        dd($_POST['aa']);
    }
}
