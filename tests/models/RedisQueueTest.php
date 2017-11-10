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


    public function testGetDone()
    {
        $done=$this->model->getDone();
        $this->assertEquals($done, $this->model->getTotal()-$this->model->getWaiting()-$this->model->getDelayed()-$this->model->getReserved());
    }

    public function testGetWorkInfo()
    {
        $this->assertSame([], $this->model->getWorkInfo());
    }

    public function testGetMessage()
    {
        $message=$this->model->getMessage(1);
        $this->assertEquals('http://example.com/image.jpg', $message->url);
        $this->assertEquals('/tmp/image.jpg', $message->file);
    }

    public function testGetStatus()
    {
        $this->assertEquals(1, $this->model->status(1));
    }
}
