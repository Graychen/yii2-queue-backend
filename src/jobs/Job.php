<?php

namespace graychen\yii2\queue\backend\jobs;

use Yii;
use yii\queue\redis\Queue;

abstract class Job extends JobAbstract
{

    public function __construct()
    {
        Yii::$app->queue->on(Queue::EVENT_AFTER_PUSH, function ($event) {
            var_dump(1111111111111);
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