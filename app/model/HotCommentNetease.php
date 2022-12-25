<?php

namespace app\model;
use think\Model;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Pool;
class HotCommentNetease extends Model
{
    public function song()
    {
        return $this->belongsTo('app\model\SongNetease', 'song_id', 'song_id');
    }

}