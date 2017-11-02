<?php
namespace graychen\yii2\queue\backend\tests;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockApplication();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyApplication();
    }



    protected function mockApplication($config = [], $appClass = '\yii\console\Application')
    {
        return new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'bootstrap' => [
                'queue',
            ],
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'sqlite::memory:'
                ],
                'i18n' => [
                    'translations' => [
                        '*' => [
                            'class' => 'yii\i18n\PhpMessageSource',
                        ]
                    ]
                ],
                'redis' => [
                    'class' => 'yii\redis\Connection',
                    'hostname' => 'redis',
                    'port' => '6379',
                    'database' => 0,
                ],
                'queue' => [
                    'class' => 'yii\queue\redis\Queue',
                    'redis' => 'redis', // Redis connection component or its config
                    'channel' => 'queue', // Queue channel key
                    'as log' => 'yii\queue\LogBehavior'
                ],
            ],
            'modules' => [
                'queue-backend' => [
                    'class' => 'graychen\yii2\queue\backend\Module'
                ]
            ]
        ], $config));
    }

    /**
     * @return string vendor path
     */
    protected function getVendorPath()
    {
        return dirname(__DIR__) . '/vendor';
    }
    /**
     * Destroys application in Yii::$app by setting it to null.
     */
    protected function destroyApplication()
    {
        if (\Yii::$app && \Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }

}
