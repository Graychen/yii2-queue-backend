<?php

namespace graychen\yii2\queue\backend\tests;

use graychen\yii2\queue\backend\models\Queue;

class QueueTest extends TestCase
{
    public $model;

    protected function setUp()
    {
        parent::setUp();
        $this->model=new Queue;
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
    }
}
