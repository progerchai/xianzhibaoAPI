<?php

namespace app\controller;

use app\BaseController;
use app\Request;

class Auth extends BaseController
{
    public function index()
    {
        dump('this is auth');
    }

    public function getOpenid(Request $request)
    { // $code为小程序提供
        $code = $request->get("code");
        $appid = 'wxe365698157629a55'; // 小程序APPID
        $secret = 'a1a74ed22d802514dfa0c263393b7493'; // 小程序secret
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=' . $appid . '&secret=' . $secret . '&js_code=' . $code . '&grant_type=authorization_code';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。    
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return json($res); // 这里是获取到的信息
    }
}
