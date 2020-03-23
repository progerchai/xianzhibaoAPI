<?php

namespace app\controller;

use app\BaseController;
use app\Request;
use Exception;
use think\facade\Db;

//用户上传闲置品数据
class Publish extends BaseController
{
    public function index()
    {
        dump("this is publish.php");
    }
    //获取活动列表
    public function upload_goods(Request $request)
    {
        $param = $request->param();
        $data = [];
        $specification = null;
        $classify_id = null;
        $pid = null;
        foreach ($param as $key => $value) {
            if ($value && $key != 'classify') {
                $data[$key] = $value;
            }
        }
        //判断是否为空任务，交给前端来执行
        try {
            //插入数据进入规格表，返回 ->规格id
            $specification = Db::name('xz_specification')
                ->insertGetId($data);
            //获取商品分类id 
            $classify_id = Db::name('xz_p_classify')->where('classify_name', $param['classify'])->value('classify_id');
            // 将规格id，商品分类id 插入商品表,返回 ->商品id
            if ($specification) {
                $pid = Db::name('xz_goods')
                    ->insertGetId(['classify_id' => $classify_id, 'specific_id' => $specification]);
            }
        } catch (Exception $e) {
            //插入失败，将对应到   规格表、商品表 中的数据删除
            if ($specification) {
                Db::name('xz_specification')->where('specific_id', $specification)
                    ->delete();
            }
            if ($classify_id) {
                Db::name('xz_goods')->where('pid', $pid)
                    ->delete();
            }
            return json(['msg' => '存储失败', 'err' => $e->getMessage()]);
        }
        //插入成功
        if ($specification && $pid) {
            return json(['data' => 1, 'msg' => '存储成功']);
        }
    }
    //上传图片接口
    public function upload_imgs()
    {
    }
}
