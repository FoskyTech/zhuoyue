<?php
namespace app\controller;

use app\common\BaseController;
use app\model\SongNetease;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        return View::fetch();
    }

    public function test()
    {
        $song = new SongNetease();
        print_r($song->getTopList());
    }

    public function qq()
    {
        return View::fetch();
    }
}
