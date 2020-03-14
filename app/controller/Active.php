<?php

namespace app\controller;

use app\BaseController;
use app\Request;
use think\facade\Db;

class Active extends BaseController
{
    public function index()
    {
        dump("this is active");
    }
    //获取活动列表
    public function get_active_list()
    {
        $list = Db::name('xz_active')->select();
        return json($list);
    }
}
