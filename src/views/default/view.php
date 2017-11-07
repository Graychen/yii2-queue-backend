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
                'id',
                [
                    'attribute' => 'description',
                    'value' => function ($model) {
                        return VarDumper::dumpAsString(json_decode($model->description));
                    }
                ]
            ],

    ]
    ) ?>

</div>
