<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\DetailView;
use zacksleo\yii2\lookup\models\Lookup;

yii\web\YiiAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Doctor */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '队列管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctor-view">

    <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'name',
                'catalog',
                [
                    'attribute' => 'status',
                    'value' => function ($model) {
                        switch ($status = $model->getStatus($model->queue_id)) {
                            case 0:
                                return "等待中";
                                break;
                            case 1:
                                return "成功";
                                break;
                            case 2:
                                return "正在执行";
                                break;
                            case -1:
                                return "失败";
                                break;
                        }
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'value' => function ($model) {
                        return date("Y-m-d H:i:s", $model->created_at);
                    }
                ],
                [
                    'attribute' => 'exec_time',
                    'value' => function ($model) {
                        return date("Y-m-d H:i:s", $model->exec_time);
                    }
                ],
                [
                    'attribute' => 'description',
                    'format' => 'html',
                    'value' => function ($model) {
                        return is_array($model->description) ? VarDumper::dumpAsString($model->description) : $model->description;
                    }
                ]
            ],

        ]
    ) ?>

</div>
