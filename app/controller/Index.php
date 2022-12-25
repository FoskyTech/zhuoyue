<?php
namespace app\controller;

use app\common\BaseController;
use think\facade\View;

class Index extends BaseController
{
    public function index()
    {
        return View::fetch();
    }

    public function qq()
    {
        return View::fetch();
    }
}
