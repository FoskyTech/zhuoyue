<?php
namespace app\controller;

use app\common\BaseController;

class Api extends BaseController
{
    public function index()
    {
        $data = [
            'song_id'   =>  0,
            'title' =>  '东京不太热',
            'images'    =>  'http://p1.music.126.net/cpoUinrExafBHL5Nv5iDHQ==/109951166361218466.jpg?param=280y280',
            'author'    =>  '封茗囧菌',
            'album' =>  '热门华语281',
            'description'   =>  '',
            'mp3_url'   =>  '',
            'pub_date'  =>  '',
            'comment_id'    =>  '',
            'comment_user_id'   =>  '',
            'comment_nickname'  =>  'Selastian',
            'comment_avatar_url'    =>  'http://p2.music.126.net/Dhoh0VFY5HhJdU8yeso1kg==/109951164413961102.jpg?param=50y50',
            'comment_content'   =>  '我已分不清，你是友情还是错过的爱情。繁华乱世，浮华虚拟，颠沛了谁许下的莫名承诺。闭眼呼吸，阳光勾勒微笑。总是期待着未来，却不知未来的路到底该怎么走。莫名的伤感，莫名的哭了。',
            'comment_pub_date'  =>  '2016年6月17日'
        ];
        return json($data);
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
            'comment_like' =>  53289,
            'comment_content'   =>  '躺卧在草地独望着晴空，总觉得那年毕业季的夏天蝉鸣额外的聒噪。而老师仿佛一直在讲着同一道题，大家在私底下悄悄地说着话，窗帘的拉卷却总也抵挡不了烈日的阳光。一缕青叶飘落在旁，我睡的很香很香，睡着睡着脸就朝向了你，口袋里五彩的糖果滚落在地上，亮起了一道晴天中的彩虹',
            'comment_pub_date'  =>  '2021年7月25日 23:35'
        ];
        return json($data);
    }
    public function count()
    {
        $data = [
            'api_request_count' => 114514
        ];
        return json($data);
    }
}
