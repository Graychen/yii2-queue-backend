<?php
namespace graychen\yii2\queue\backend\models;

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
            'id' => Yii::t('app/queue','ID'),
            'queue_id' => Yii::t('app/queue','队列id'),
            'catalog' => Yii::t('app/queue','类别'),
            'name' => Yii::t('app/queue','任务名称'),
            'description' => Yii::t('app/queue','详请信息'),
            'exec_time' => Yii::t('app/queue','执行时间'),
            'status' => Yii::t('app/queue','状态'),
            'created_at' => Yii::t('app/queue','队列创建时间'),
            'updated_at' => Yii::t('app/queue','队列修改时间'),
            'execution_time' => Yii::t('app/queue','队列执行时间')
        ];
    }

    public function getExecutionTime()
    {
        return $this->exec_time+$this->created_at;
    }

    public function getStatus($id){
        if(Yii::$app->queue->isWaiting($id) || Yii::$app->queue->isReserved($id)){
            $status=0;
        }elseif(Yii::$app->queue->isDone($id)){
            $status=1;
        }else{
            $status=-1;
        }
        return $status;
    }


}
