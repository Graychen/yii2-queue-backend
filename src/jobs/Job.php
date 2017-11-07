<?php

namespace graychen\yii2\queue\backend\jobs;
use yii\base\Object;
use yii;
use yii\queue\Queue;
use graychen\yii2\queue\backend\models\Queue as QueueDb;

abstract class Job extends Object implements JobInterface
{
    public function __construct()
    {
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
            $id=$event->id;
            $queue = new QueueDb();
            $queue->name=$this->getName();
            $queue->catalog=$this->getCatalog();
            $queue->description=json_encode($this->getDescription());
            $queue->exec_time=$event->delay;
            $queue->queue_id=$event->id;
            $queue->save();
        });
    }

    /** name (任务名称)
     * @return string
     */
    abstract function getName();

    /** catalog (类别: 推送任务, 上传报告)
     * @return string
     */
    abstract function getCatalog();

    /** description (队列详情)
     * @return string
     */
    abstract function getDescription();

}