<?php

namespace app\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\facade\Log;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;

use app\model\SongNetease;

class SongNeteaseSync extends Command
{
    // 工作线程数
    protected $concurrency = 5;
    // 传入的歌曲列表
    protected $songList = [];
    // 列表数量
    protected $total = 0;
    protected function configure()
    {
        // 指令配置
        $this->setName('song:netease')
            ->addArgument('list', Argument::OPTIONAL, "指定歌单")
            ->addOption('id', null, Option::VALUE_OPTIONAL, '歌单id')
            ->setDescription('获取网易云音乐数据');
    }

    protected function execute(Input $input, Output $output)
    {
        $netease = new SongNetease();

        if ($input->hasOption('id')) {
            $id = $input->getOption('id');
            $this->songList = $netease->getPlayList($id);
        } else {
            $list = $input->getArgument('list');
            $list = $list ?: 'toplist';
            if ($list == 'toplist') {
                $this->songList = $netease->getTopList();
            }
        }

        $this->total = count($this->songList);

        $output->writeln('歌曲总数：' . $this->total);

        $client = new Client();
        $songList = $this->songList;
        $requests = function ($total) use ($client, $songList) {
            foreach ($songList as $song) {
                $uri = 'http://music.163.com/api/song/detail?ids=['.$song['id'].']';
                yield function() use ($client, $uri) {
                    return $client->getAsync($uri);
                };
            }
        };

        $pool = new Pool($client, $requests($this->total), [
            'concurrency' => $this->concurrency,
            'fulfilled' => function ($response, $index) use ($client) {

                // 获取歌曲详情
                $songContents = json_decode($response->getBody()->getContents(), true);
                // 拆解组合歌曲详情
                $songInfo = [
                    'song_id' => array_get($songContents, 'songs.0.id'),
                    'title' => array_get($songContents, 'songs.0.name'),
                    'images' => 'https:'.ltrim(array_get($songContents, 'songs.0.album.picUrl'), 'http:'),
                    'author' => array_get($songContents, 'songs.0.artists.0.name'),
                    'description' => sprintf(
                        '歌手：%s。所属专辑：%s。',
                        array_get($songContents, 'songs.0.artists.0.name'),
                        array_get($songContents, 'songs.0.album.name')
                    ),
                    'album' => array_get($songContents, 'songs.0.album.name'),
                    'published_date' => date('Y-m-d H:i:s', (int)(array_get($songContents, 'songs.0.album.publishTime') / 1000)),
                ];
                // 如果获取失败则跳过
                if (!$songInfo['song_id']) return false;
                $song = new SongNetease($songInfo);

                // 如果歌曲已收录则跳过
                if ($song->where('song_id', $songInfo['song_id'])->count()) {
                    return false;
                }
                // 保存歌曲
                $song->save();

                // 获取热评
                $hotCommentsResponse = $client->request('GET', 'http://music.163.com/api/v1/resource/comments/R_SO_4_'. $songInfo['song_id'] .'?limit=15&offset=0');

                $_hotComments = json_decode($hotCommentsResponse->getBody()->getContents(), true);

                $hotComments = [];

                foreach ($_hotComments['hotComments'] as $hotc) {
                    $hotComments[] = [
                        'user_id' => $hotc['user']['userId'],
                        'nickname' => $hotc['user']['nickname'],
                        'avatar_url' => 'https:'.ltrim($hotc['user']['avatarUrl'], 'http:'),
                        'comment_id' => $hotc['commentId'],
                        'liked_count' => $hotc['likedCount'],
                        'content' => preg_replace('/\s+/', ' ', $hotc['content']),
                        'published_date' => date('Y/m/d H:i:s', (int)($hotc['time'] / 1000)),
                    ];
                }
dump($hotComments);


                // 保存热评
                $song->hotcomment()->saveAll($hotComments);

                if (++$index == $this->total) {
                    Log::info('同步完成,同步数: '. $this->total);
                }
            },
            'rejected' => function ($reason, $index){
                Log::error('同步失败,异常消息: '. $reason);
            },
        ]);

        $promise = $pool->promise();
        $promise->wait();
        // 指令输出
        $output->writeln('song:netease');
    }
}
