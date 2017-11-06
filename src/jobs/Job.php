<?php

namespace graychen\yii2\queue\backend\jobs;

use Yii;
use yii\queue\redis\Queue;
use graychen\yii2\queue\backend\models\Queue as QueueDb;

abstract class Job extends JobAbstract
{



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




}
