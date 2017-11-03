<?php

namespace graychen\yii2\queue\backend\jobs;
use yii\base\Object;
abstract class JobAbstract extends Object implements JobInterface
{
    public $name;
    public $catalog;
    public $description;
    public $execTime;

    /** name (任务名称)
     * @return mixed
     */
    abstract function getName();

    /** catalog (类别: 推送任务, 上传报告)
     * @return mixed
     */
    abstract function getCatalog();

    /** description (详情信息)
     * @return mixed
     */
    abstract function getDescription();
    /**
     * @return mixed  int  时间戳
     */
    abstract function getExecTime();
}