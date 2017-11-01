<?php

namespace graychen\yii2\queue\backend\controllers;

use yii\web\Controller;
use graychen\yii2\queue\backend\models\Queue;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        $queue=new Queue();
        return $this->render('index', ['queue'=>$queue]);
    }
}
