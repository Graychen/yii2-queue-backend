<?php

namespace graychen\yii2\queue\backend\jobs;

use yii\base\BaseObject;
use yii;
use yii\queue\Queue;
use graychen\yii2\queue\backend\models\Queue as QueueDb;

abstract class Job extends BaseObject implements JobInterface
{
    public function init()
    {
        parent::init();
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
            $delay=$event->delay>=0 ?$event->delay : 0;
            $queue = new QueueDb();
            $queue->name=$this->getName();
            $queue->catalog=$this->getCatalog();
            $queue->description=$this->getDescription();
            $queue->exec_time=$delay + time();
            $queue->queue_id=$event->id;
            $queue->save();
        });
        //增加错误日志
        Yii::$app->queue->on(Queue::EVENT_AFTER_ERROR, function (ErrorEvent $event) {
            if ($event->job instanceof \graychen\yii2\queue\backend\jobs\ BaseObject) {
                $model = Queue::findOne(['queue_id'=>$event->id]);
                $model->log = $event->error;
                $model->save();
            }
        });
    }

    /** name (任务名称)
     * @return string
     */
    abstract public function getName();

    /** catalog (类别: 推送任务, 上传报告)
     * @return string
     */
    abstract public function getCatalog();

    /** description (队列详情)
     * @return string
     */
    abstract public function getDescription();
}
