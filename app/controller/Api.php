<?php
namespace app\controller;

use app\common\BaseController;
use app\model\HotCommentNetease;
use think\facade\Cache;

class Api extends BaseController
{
    public function index()
    {
        if (!Cache::has('api_count')) {
            Cache::set('api_count', 0, 86400 * 365 * 100);
        }
        Cache::inc('api_count');
        return json(HotCommentNetease::getOneRandHotComment());
    }

    public function qq()
    {
        $data = [
            'song_id'   =>  0,
            'title' =>  '晴天',
            'images'    =>  '/photo/qq/97773.jpg',
            'author'    =>  '周杰伦',
            'album' =>  '叶惠美',
            'description'   =>  '《晴天》是一首偏校园怀旧风的歌曲，会想到你的校园、你暗恋的对象、青涩的天真和单纯的永恒。',
            'mp3_url'   =>  '',
            'pub_date'  =>  '2003-07-31',
            'comment_id'    =>  '',
            'comment_user_id'   =>  '',
            'comment_nickname'  =>  '夏目与鱼',
            'comment_avatar_url'    =>  'https://y.qq.com/music/common/upload/t_celebrity_certification/4150917.jpg',
            'comment_liked_count' =>  53289,
            'comment_content'   =>  '躺卧在草地独望着晴空，总觉得那年毕业季的夏天蝉鸣额外的聒噪。而老师仿佛一直在讲着同一道题，大家在私底下悄悄地说着话，窗帘的拉卷却总也抵挡不了烈日的阳光。一缕青叶飘落在旁，我睡的很香很香，睡着睡着脸就朝向了你，口袋里五彩的糖果滚落在地上，亮起了一道晴天中的彩虹',
            'comment_pub_date'  =>  '2021年7月25日 23:35'
        ];
        return json($data);
    }
    public function count()
    {
        $data = [
            'api_request_count' => Cache::get('api_count')
        ];
        return json($data);
    }
}
