<?php

use yii\bootstrap\ActiveForm;
use yii\grid\GridView;

$this->title = '队列统计';
$this->params['breadcrumbs'][] = $this->title;
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $queue \graychen\yii2\queue\backend\models\RedisQueue */
?>
<div class="appointment-order-index">
    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}<div class=\"col-lg-3\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-3 control-label'],
        ]
    ]); ?>

    <ul class="nav nav-pills" role="tablist">
        <button type="button" class="btn btn-primary btn-lg">总数(total):<span class="badge"><?= $queue->total ?></span>
        </button>
        <button type="button" class="btn btn-success btn-lg">完成(done):<span class="badge"><?= $queue->done ?></span>
        </button>
    </ul>
    <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-danger">等待(waiting)：<span class="badge"><?= $queue->waiting ?></span>
        </button>
        <button type="button" class="btn btn-warning">延迟(delayed):<span class="badge"><?= $queue->delayed ?></span>
        </button>
        <button type="button" class="btn btn-default">保留(reserved):<span class="badge"><?= $queue->reserved ?></span>
        </button>
    </div>
    <h2 class="page-title">队列信息</h2>
    <div id="w1" class="grid-view">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>队列ID</th>
                <th>队列地址</th>
                <th>队列名字</th>
                <th>队列位数</th>
                <th>运行时间</th>
            </thead>
            <tbody>
            <?php foreach ($queue->getWorkInfo() as $key => $value) {
        ?>
                <tr>
                    <td>
                        <?= $value['id'] ?>
                    </td>
                    <td>
                        <?= $value['addr'] ?>
                    </td>
                    <td>
                        <?= $value['name'] ?>
                    </td>
                    <td>
                        <?= $value['fd'] ?>
                    </td>
                    <td>
                        <?= $value['age'] ?>
                    </td>
                </tr>
            <?php
    }
        ?>
            </tbody>
        </table>
    </div>
    <h2 class="page-title">队列详情</h2>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'catalog',
            'name',
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
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ]
        ],
    ]); ?>

    <?php ActiveForm::end(); ?>


</div>
