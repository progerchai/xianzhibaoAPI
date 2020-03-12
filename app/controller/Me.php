<?php
/*
 *@description: modul me
 *@author: progerchai
 *@e-mail: progerchai@qq.com
 *@date: 2020-03-12 21:28:29
*/

namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Me extends BaseController
{
    public function index()
    {
        $data = [
            ['id' => 2, 'introduce' => 'foo'],
            ['id' => 3, 'introduce' => 'foo1'],
            ['id' => 4, 'introduce' => 'foo2']
        ];
        Db::name('user')->insertAll($data);
    }
}
