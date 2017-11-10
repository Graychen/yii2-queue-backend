<?php

namespace graychen\yii2\queue\backend\tests\controllers;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use graychen\yii2\queue\backend\models\RedisQueue;
use graychen\yii2\queue\backend\models\Queue;

class DefaultController extends Controller
{


    public function actionIndex()
    {   
        $queue = new RedisQueue();
        $query = Queue::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'queue_id' => SORT_DESC
                ]
            ]
        ]);
        return ['queue' => $queue, 'dataProvider' => $dataProvider];
    }

    public function actionView($id)
    {
        $model = Queue::find()->where(['id' => $id])->one();
        return $model;
    }
}
