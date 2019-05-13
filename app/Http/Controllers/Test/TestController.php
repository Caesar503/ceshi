<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Xcrypt;
class TestController extends Controller
{

    public function test()
    {
        //加密
        $data = 'woshinibaba';
        $method = "AES-256-CBC";
        $key = "zhaokai";
        $options =OPENSSL_RAW_DATA;
        $iv = 'qweasdzxcqweasqq';

        $enc = openssl_encrypt($data,$method,$key,$options,$iv);
        $bs = base64_encode($enc);
        echo $bs;
        echo "<hr>";
        //创建一个curl资源
        $aa = curl_init();
        $url = "http://api_lumen.1809.com/test?str=".$bs;
//        echo $url;die;
        //设置curl参数和配置项
        curl_setopt($aa,CURLOPT_URL,$url);
        curl_setopt($aa,CURLOPT_HEADER,0);
        curl_setopt($aa,CURLOPT_RETURNTRANSFER,true);
        //住区并把它传给浏览器
        $res = curl_exec($aa);
        $code = curl_errno($aa);
        echo $code;

        $res1 = openssl_decrypt( base64_decode($res),$method,$key,$options,$iv);
        echo $res1;
        curl_close($aa);
    }
    public function test1()
    {
        $str = 'kaishi wo men dou shi hai zi ';
        //加密
        $ascii = $this->jiami($str);
        echo $ascii;
        echo "<hr>";
        //解密
        $encrypt = $this->decrypt($ascii);
        echo $encrypt;


//        // 加密
//         $encrypted = openssl_encrypt($data, $encryptMethod, 'secret', 0, $iv);
//        echo $encrypted;echo "<hr>";
//        $arr = ['haha'=>$encrypted];
//
//        //创建一个curl资源
//        $aa = curl_init();
//        $url = "http://api_lumen.1809.com/test1";
//        //设置url和相对应的选项
//        curl_setopt($aa,CURLOPT_URL,$url);
//        curl_setopt($aa,CURLOPT_RETURNTRANSFER,true);
//        curl_setopt($aa,CURLOPT_POST,1);
//        curl_setopt($aa,CURLOPT_POSTFIELDS,$arr);
//        //抓取url并将其返回到浏览器上
//        $res = curl_exec($aa);
//        $code = curl_errno($aa);
//        echo $code;
//        //关闭资源
//        dump(json_decode($res,true));
//        curl_close($aa);
    }
    //加密
    function jiami($str,$n=1)
    {
        $num = strlen($str);
        $enc = "";
        for($i=0;$i<$num;$i++)
        {
            //加密
            $ascii =  ord($str[$i])+$n;
            $enc .= chr($ascii);
        }
        return $enc;
    }
    //解密
    function decrypt($str,$n=1)
    {
        $enc = "";
        for($i=0;$i<strlen($str);$i++)
        {
//            echo $str[$i];
            $enc1 = ord($str[$i])-$n;
            $enc .= chr($enc1);
        }
        return $enc;
    }

    public function test_post()
    {
        //加密
        $method = "AES-256-CBC";
        $key = "zhaokai";
        $options =OPENSSL_RAW_DATA;
        $iv = 'qweasdzxcqweasqq';
        $arr = [
            'a'=>131809809809,
            'b'=>'asdasdasd',
            'c'=>"赵恺"
        ];
        $json_arr = json_encode($arr);
        $enc = openssl_encrypt($json_arr,$method,$key,$options,$iv);
        $bs = base64_encode($enc);
        echo $bs;

        //创建一个curl资源
        $aa = curl_init();
        $url = "http://api_lumen.1809.com/test2";
        //设置url和相对应的选项
        curl_setopt($aa,CURLOPT_URL,$url);
        curl_setopt($aa,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($aa,CURLOPT_POST,1);
        curl_setopt($aa,CURLOPT_POSTFIELDS,$bs);//raw
        curl_setopt($aa,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        //抓取url并将其返回到浏览器上
        $res = curl_exec($aa);
        $code = curl_errno($aa);
        echo $code;
        //关闭资源

         $res1 = openssl_decrypt(base64_decode($res),$method,$key,OPENSSL_RAW_DATA,$iv);
        dump(json_decode($res1,true));
        curl_close($aa);

    }

    public function test3()
    {
        $arr = [
            'a'=>131809809809,
            'b'=>'asdasdasd',
            'c'=>"赵恺"
        ];
//        echo storage_path("app/keys/rsa_private_key.pem");
        //获取密钥
        $pk = openssl_pkey_get_private("file://".storage_path("app/keys/rsa_private_key.pem"));
        dump($pk);
        //通过密钥进行加密
        openssl_private_encrypt(json_encode($arr,JSON_UNESCAPED_UNICODE),$pk_enc,$pk);
        echo base64_encode($pk_enc);
        echo "<hr>";

        $aa = curl_init();
        $url = "http://api_lumen.1809.com/test3";
        curl_setopt($aa,CURLOPT_URL,$url);
        curl_setopt($aa,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($aa,CURLOPT_POST,1);
        curl_setopt($aa,CURLOPT_POSTFIELDS,base64_encode($pk_enc));
        curl_setopt($aa,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $code = curl_errno($aa);
        $res = curl_exec($aa);
        echo $code;
        curl_close($aa);

        //通过密钥 解密公钥
        openssl_private_decrypt(base64_decode($res),$pp,$pk);
        dump(json_decode($pp,true));

        //获取公钥
//        $pk1 = openssl_pkey_get_public("file://".storage_path('app/keys/rsa_public_key.pem'));
//        //通过公钥进行解密
//        openssl_public_decrypt($pk_enc,$pk_den,$pk1);
//        print_r(json_decode($pk_den,true));
    }

    public function test4()
    {
        $arr = [
            'a'=>131809809809,
            'b'=>'asdasdasd',
            'c'=>"赵恺"
        ];
        $arr1 = json_encode($arr);
//        echo storage_path("app/keys/rsa_private_key.pem");
        //获取密钥
        $pk = openssl_pkey_get_private("file://".storage_path("app/keys/rsa_private_key.pem"));
        //通过密钥进行签名
        openssl_sign($arr1,$sign,$pk);
        $json_sign= base64_encode($sign);
//        echo "<hr>";
        $aa = curl_init();
        $url = "http://api_lumen.1809.com/test4?sign=".urlencode($json_sign);
//        echo $url;
//        echo base64_encode($arr1);
        curl_setopt($aa,CURLOPT_URL,$url);
        curl_setopt($aa,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($aa,CURLOPT_POST,1);
        curl_setopt($aa,CURLOPT_POSTFIELDS,base64_encode($arr1));
        curl_setopt($aa,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $code = curl_errno($aa);
        $res = curl_exec($aa);
        echo $code;
        curl_close($aa);

        dump($res);
    }
}
