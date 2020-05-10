<?php

namespace app\controller;

use app\BaseController;
use app\Request;
use Qcloud\Sms\SmsSingleSender;

class Message extends BaseController
{
    public function index()
    {
        dump('this is index');
    }
    //发送短信
    public function sendMessage(Request $request)
    {
        $data = $request->param();
        $message = $data['message'];
        $mobile = $data['mobile'];
        $appid = 1400333569; // SDK AppID 以1400开头

        // 短信应用 SDK AppKey
        $appkey = "ec0690d4b888b06ead835539a339f6ce";

        // 需要发送短信的手机号码
        $phoneNumbers = [$mobile];

        // 短信模板 ID，需要在短信控制台中申请
        $templateId = 554628;  // NOTE: 这里的模板 ID`7839`只是示例，真实的模板 ID 需要在短信控制台中申请
        $smsSign = "张笑的个人代码测试"; // NOTE: 签名参数使用的是`签名内容`，而不是`签名ID`。这里的签名"腾讯云"只是示例，真实的签名需要在短信控制台申请
        // 指定模板ID单发短信
        $params = [$message];
        try {
            $ssender = new SmsSingleSender($appid, $appkey);

            $result = $ssender->sendWithParam(
                "86",
                $phoneNumbers[0],
                $templateId,
                $params,
                $smsSign,
                "",
                ""
            );  // 签名参数未提供或者为空时，会使用默认签名发送短信
            $rsp = json_decode($result);
            return  $result;
        } catch (\Exception $e) {
            echo var_dump($e);
        }
        echo "\n";
        // return json(["res"=>1]);

    }
}
