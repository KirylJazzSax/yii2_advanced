<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01.10.2019
 * Time: 19:16
 */
use yii\helpers\Html;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Html::a(Html::encode($model->username), ['view', 'id' => $model->id])?>
    </div>
    <div class="panel-body">
        <?= \Yii::$app->formatter->asNtext($model->description)?>
    </div>
</div>
