<?php

namespace graychen\yii2\queue\backend\jobs;

use Yii;
use yii\queue\redis\Queue;
use graychen\yii2\queue\backend\models\Queue as QueueDb;

abstract class Job extends JobAbstract
{

    public function __construct()
    {
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
            $queue = new QueueDb();
            $queue->name=$this->getName();
            var_dump($queue->name);
            $queue->catalog=$this->getCatalog();
            var_dump($queue->catalog);
            $queue->description=$this->getDescription();
            var_dump($queue->description);
            $queue->execTime=$this->getExecTime();
            var_dump($queue->execTime);
            $this->save();
        });
    }

    /** name (任务名称)
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /** catalog (类别: 推送任务, 上传报告)
     * @return mixed
     */
    public function getCatalog()
    {
        return $this->catalog;
    }

    /** description (详情信息)
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed  int  时间戳
     */
    public function getExecTime()
    {
        return $this->execTime;
    }


}
