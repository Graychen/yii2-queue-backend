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
            'status' => Yii::t('app/queue','状态:0 未执行;1 成功;-1 失败'),
            'created_at' => Yii::t('app/queue','队列创建时间'),
            'updated_at' => Yii::t('app/queue','队列执行时间')
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

    }

    public function beforeValidate()
    {

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        return parent::beforeDelete();
    }

    public function afterDelete()
    {

        parent::afterDelete();
    }


}