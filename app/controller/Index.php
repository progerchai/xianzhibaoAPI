<?php

namespace app\controller;

use app\BaseController;
use Firebase\JWT\JWT;
use app\Request;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        dump('this is index');
    }
    //获取首页数据
    public function get_index_message()
    {
        $msg = '访问失败！';
        $imglist = Db::name('xz_scroll_imgs')->select();
        $product = [1];
        if ($imglist && $product)
            $msg = 'seccess';
        return json(['imglist' => $imglist, 'product' => $product, 'msg' => $msg]);
    }
    //获取首页商品数据
    public function get_index_products()
    {
        $msg = '访问失败！';
        $goodslist = Db::name('xz_goods')->select();
        $specificlist = Db::name('xz_specification')->select();
        $goods = [];
        for ($i = 0; $i < sizeof($goodslist); $i++) {
            for ($j = 0; $j < sizeof($specificlist); $j++) {
                $obj = null;
                if ($goodslist[$i]['specific_id'] == $specificlist[$j]['specific_id']) {
                    $obj = $specificlist[$j];
                    $obj['pid'] = $goodslist[$i]['pid'];
                    array_push($goods, $obj);
                }
            }
        }
        return json(['goods' => $goods]);
    }

    //获取商品详情数据
    public function get_product_detail(Request $request)
    {
        $data = $request->param();
        $pid = $data['pid'];
        $specific_id = Db::name('xz_goods')->where('pid', $pid)->select()[0];
        $detail = Db::name('xz_specification')->where('specific_id', $specific_id["specific_id"])->select()[0];
        $detail['pid'] = $pid;
        return json(['detail' => $detail]);
    }
    // token鉴权
    public function jwt()
    {
        $key = 'ffdsfsd@4_45'; //key
        $time = time(); //当前时间

        //公用信息
        $token = [
            'iss' => 'http://www.helloweba.net', //签发者 可选
            'iat' => $time, //签发时间
            'data' => [ //自定义信息，不要定义敏感信息
                'userid' => 1,
            ]
        ];
        $access_token = $token; // access_token
        $access_token['scopes'] = 'role_access'; //token标识，请求接口的token
        $access_token['exp'] = $time + 10 * 60; //access_token过期时间,这里设置10分钟

        $refresh_token = $token; //refresh_token
        $refresh_token['scopes'] = 'role_refresh'; //token标识，刷新access_token
        $refresh_token['exp'] = $time + (86400 * 30); //refresh_token过期时间,这里设置30天

        $jsonList = [
            'access_token' => JWT::encode($access_token, $key),
            'refresh_token' => JWT::encode($refresh_token, $key),
            'token_type' => 'bearer' //token_type：表示令牌类型，该值大小写不敏感，这里用bearer
        ];
        Header("HTTP/1.1 201 Created");
        return json($jsonList); //返回给客户端token信息
    }
}
