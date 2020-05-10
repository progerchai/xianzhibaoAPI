<?php

namespace app\controller;

use app\BaseController;
use Qiniu\Auth;

class Qiniu extends BaseController
{
    public function index()
    {
        return json(['desc' => 'this is qiniu index']);
    }

    public function upload_image_get_token()
    {
        // 需要填写你的 Access Key 和 Secret Key
        $accessKey = "eFR06-fmXgq7iyNplfW8KBoSXE4waqu1OpwJWJWZ";
        $secretKey = "83WOcbuhWHrH9U0I_qorBGaTDWx_PHod-nmYDmCT";
        $bucket = "xianzhibao";
        $auth = new Auth($accessKey, $secretKey);

        // 生成上传Token
        $token = $auth->uploadToken($bucket);
        return json(['token' => $token]);
    }
}
