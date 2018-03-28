<?php

namespace graychen\yii2\queue\backend\models;

use graychen\yii2\queue\backend\Module;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Queue extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%queue}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['queue_id', 'catalog', 'name', 'description'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('queue', 'ID'),
            'queue_id' => Module::t('queue', 'Queue ID'),
            'catalog' => Module::t('queue', 'Catalog'),
            'name' => Module::t('queue', 'Name'),
            'description' => Module::t('queue', 'Description'),
            'exec_time' => Module::t('queue', 'Exec Time'),
            'status' => Module::t('queue', 'Status'),
            'created_at' => Module::t('queue', 'Created At'),
            'updated_at' => Module::t('queue', 'Updated At'),
        ];
    }

    public function getExecutionTime()
    {
        return $this->exec_time + $this->created_at;
    }

    public function getStatus($id)
    {
        if (Yii::$app->queue->isWaiting($id)) {
            $status = 0;
        } elseif (Yii::$app->queue->isReserved($id)) {
            $status = 2;
        } elseif (Yii::$app->queue->isDone($id)) {
            $status = 1;
        } else {
            $status = -1;
        }
        return $status;
    }
}
