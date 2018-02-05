<?php

namespace graychen\yii2\queue\backend\tests\models;

use graychen\yii2\queue\backend\models\Queue;
use graychen\yii2\queue\backend\tests\TestCase;
use graychen\yii2\queue\backend\tests\models\jobs\DownloadJob;
use yii;

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

    public function testRules()
    {
        $this->assertTrue($this->model->isAttributeRequired('queue_id'));
        $this->assertTrue($this->model->isAttributeRequired('catalog'));
        $this->assertTrue($this->model->isAttributeRequired('name'));
        $this->assertTrue($this->model->isAttributeRequired('description'));
        $this->model->queue_id='1';
        $this->model->catalog='类别';
        $this->model->name='任务名称';
        $this->model->description='详请信息';
        $this->assertTrue($this->model->save());
    }

    public function testAttributeLabels()
    {
        $labels=$this->model->attributeLabels();
        $this->assertArrayHasKey('id', $labels);
        $this->assertArrayHasKey('queue_id', $labels);
        $this->assertArrayHasKey('catalog', $labels);
        $this->assertArrayHasKey('name', $labels);
        $this->assertArrayHasKey('description', $labels);
        $this->assertArrayHasKey('exec_time', $labels);
        $this->assertArrayHasKey('status', $labels);
        $this->assertArrayHasKey('created_at', $labels);
        $this->assertArrayHasKey('updated_at', $labels);
    }

    public function testGetExecutionTime()
    {
        $this->model->setAttribute('exec_time', '1');
        $this->model->setAttribute('created_at', '2');
        $this->assertEquals('3', $this->model->getExecutionTime());
    }


    public function testGetStatus()
    {
        $id=Yii::$app->queue->push(new DownloadJob([
            'url' => 'http://example.com/image.jpg',
            'file' => '/tmp/image.jpg',
        ]));
        $this->assertEquals(0, $this->model->getStatus($id));
        $id_delay=Yii::$app->queue->delay(5 * 60)->push(new DownloadJob([
            'url' => 'http://example.com/image.jpg',
            'file' => '/tmp/image.jpg',
        ]));
        $this->assertEquals(0, $this->model->getStatus($id_delay));
    }
}
