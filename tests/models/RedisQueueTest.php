<?php

namespace graychen\yii2\queue\backend\tests\models;

use graychen\yii2\queue\backend\models\RedisQueue;
use graychen\yii2\queue\backend\tests\TestCase;

class RedisQueueTest extends TestCase
{
    public $model;

    protected function setUp()
    {
        parent::setUp();
        $this->model=new RedisQueue;
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testGetPrefix()
    {
        $this->assertEquals('queue', $this->model->prefix);
    }

    public function testGetWaiting()
    {
        var_dump($this->model->getWaiting());
    }
}
