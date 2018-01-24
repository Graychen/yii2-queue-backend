<?php

namespace graychen\yii2\queue\backend\tests\models\jobs;

use graychen\yii2\queue\backend\jobs\Job;
use yii\queue\JobInterface;

class DownloadJob extends Job implements JobInterface
{
    public $url;
    public $file;

    public function execute($queue)
    {
        file_put_contents($this->file, file_get_contents($this->url));
    }

    public function getName()
    {
        return "下载队列";
    }

    public function getCatalog()
    {
        return "下载任务";
    }

    public function getDescription()
    {
        return '下载url:'.$this->url.
            '下载文件:'.$this->file;
    }
}
