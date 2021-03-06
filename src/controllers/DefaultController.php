<?php

namespace graychen\yii2\queue\backend\controllers;

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
                    'created_at' => SORT_DESC
                ]
            ]
        ]);
        return $this->render('index', ['queue' => $queue, 'dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $model = Queue::find()->where(['id' => $id])->one();
        return $this->render('view', ['model' => $model]);
    }
}
