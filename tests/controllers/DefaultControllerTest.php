<?php
namespace graychen\yii2\queue\backend\tests\controllers;

use Yii;
use graychen\yii2\queue\backend\tests\TestCase;
use graychen\yii2\queue\backend\tests\models\jobs\DownloadJob;

class DefaultControllerTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
        Yii::$app->queue->push(new DownloadJob([
            'url' => 'http://example.com/image.jpg',
            'file' => '/tmp/image.jpg',
        ]));
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    public function testIndex()
    {
        $param = [
            'index' => []
        ];
        Yii::$app->request->queryParams = $param;
        $res=Yii::$app->runAction('queue-backend/default');
        $this->assertEquals(1, $res['dataProvider']->getTotalCount());
        $this->assertEquals('queue', $res['queue']->prefix);
    }

    public function testView()
    {
        $res=Yii::$app->runAction('queue-backend/default/view', ['id' => 1]);
        $this->assertEquals('下载任务', $res->catalog);
    }
}
