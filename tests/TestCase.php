<?php
namespace graychen\yii2\queue\backend\tests;

use Yii;
use yii\base\Exception;
use yii\helpers\ArrayHelper;

/**
 * This is the base class for all yii framework unit tests.
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        parent::setUp();
        $this->mockWebApplication();
        $this->createTestDbData();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->destroyTestDbData();
        $this->destroyWebApplication();
    }

    protected function mockWebApplication($config = [], $appClass = '\yii\web\Application')
    {
        return new $appClass(ArrayHelper::merge([
            'id' => 'testapp',
            'basePath' => __DIR__,
            'vendorPath' => $this->getVendorPath(),
            'bootstrap' => [
                'queue'
            ],
            'components' => [
                'db' => [
                    'class' => 'yii\db\Connection',
                    'dsn' => 'mysql:host=localhost:3306;dbname=test',
                    'username' => 'root',
                    'password' => '',
                    'tablePrefix' => 'tb_'
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
                    'hostname' => 'localhost',
                    'password' => null,
                    'database' => 0
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
                    'class' => 'graychen\yii2\queue\backend\Module',
                    'controllerNamespace' => 'graychen\yii2\queue\backend\tests\controllers'
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
    protected function destroyWebApplication()
    {
        if (\Yii::$app && \Yii::$app->has('session', true)) {
            \Yii::$app->session->close();
        }
        \Yii::$app = null;
    }

    protected function destroyTestDbData()
    {
        $db = Yii::$app->getDb();
        $db->createCommand()->dropTable('tb_queue')->execute();
    }

    protected function createTestDbData()
    {
        //Yii::$app->runAction('/migrate/up', ['migrationPath' => '@migrate']);
        $db = Yii::$app->getDb();
        $sql = <<<EOF
            -- auto-generated definition
            create table tb_queue
            (
                id bigint auto_increment
                    primary key,
                queue_id int null,
                catalog varchar(50) null,
                name varchar(50) null,
                description text null,
                exec_time int null,
                status smallint null,
                created_at int null,
                updated_at int null
            )
            ;
            
            create index idx_queue
                on tb_queue (queue)
            ;
EOF;
        try {
            $db->createCommand($sql)->execute();
        } catch (Exception $e) {
            return;
        }
    }
}
