<?php
namespace app\controller;

use app\common\BaseController;
use app\model\SongNetease;
use think\facade\View;
use think\facade\Request;

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

    public function music_netease()
    {
        $url = sprintf('https://music.163.com/song/media/outer/url?id=%s.mp3', Request::param('song_id'));
        return redirect($url);
    }
}
