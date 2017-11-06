<?php

namespace graychen\yii2\queue\backend\jobs;
use yii\base\Object;
use yii;
use yii\queue\Queue;
use graychen\yii2\queue\backend\models\Queue as QueueDb;

abstract class JobAbstract extends Object implements JobInterface
{
    public $name;
    public $catalog;

    public function __construct()
    {
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
            $id=$event->id;
            $queue = new QueueDb();
            $queue->name=$this->getName();
            $queue->catalog=$this->getCatalog();
            $queue->description=json_encode($event->job);
            $queue->exec_time=$event->delay;
            $queue->queue_id=$event->id;
            $status=$this->getStatus($id);
            $queue->status=$status;
            $queue->save();
        });
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
           // if ($event->error instanceof TemporaryUnprocessableJobException) {
                $id=$event->id;
                $queue = QueueDb::findOne(['queue_id'=>$id]);
                $queue->status=-1;
                $queue->save();
           // }
        });
        Yii::$app->queue->on(Queue::EVENT_AFTER_EXEC, function ($event) {
            $id=$event->id;
            $queue = QueueDb::findOne(['queue_id'=>$id]);
            $queue->status=$this->getStatus($id);
            $queue->save();
        });
    }

    public function getStatus($id){
        if(Yii::$app->queue->isWaiting($id)){
            $status=1;
        }elseif(Yii::$app->queue->isReserved($id)){
            $status=2;
        }elseif(Yii::$app->queue->isDone($id)){
            $status=3;
        }
        return $status;
    }

    /** name (任务名称)
     * @return mixed
     */
    abstract function getName();

    /** catalog (类别: 推送任务, 上传报告)
     * @return mixed
     */
    abstract function getCatalog();

}