<?php

namespace app\model;
use think\facade\Db;
use think\Model;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Pool;
class HotCommentNetease extends Model
{
    public function song()
    {
        return $this->belongsTo('app\model\SongNetease', 'song_id', 'song_id');
    }

    public static function getRandHotComment($length=1)
    {
        $comments = [];
        for ($i=0; $i<$length; $i++) {
            $comments[] = self::getOneRandHotComment();
        }

        return $comments;
    }

    public static function getOneRandHotComment()
    {
        $song = Db::name('song_netease')
            ->orderRand()
            ->find();
        $comment_origin = Db::name('hot_comment_netease')
            ->where('song_id', $song['song_id'])
            ->orderRand()
            ->find();

        $comment = [
            'song_id'   =>  $song['song_id'],
            'title' =>  $song['title'],
            'images'    =>  $song['images'],
            'author'    =>  $song['author'],
            'album' =>  $song['album'],
            'description'   =>  $song['description'],
            'mp3_url'   =>  '',
            'pub_date'    =>  $song['published_date'],
            'comment_id'    =>  $comment_origin['song_id'],
            'comment_user_id'   =>  $comment_origin['user_id'],
            'comment_nickname'  =>  $comment_origin['nickname'],
            'comment_avatar_url'    =>  $comment_origin['avatar_url'],
            'comment_liked_count'   =>  $comment_origin['liked_count'],
            'comment_content'   =>  $comment_origin['content'],
            'comment_published_date'    =>  $comment_origin['published_date']
        ];
        // 插入音乐链接
        $comment['mp3_url'] = 'https://zy.fosky.top/music/netease/' . $comment['song_id'];

        // TODO 歌词链接 http://music.163.com/api/song/media?id=

        return $comment;
    }

}