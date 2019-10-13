<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2019
 * Time: 19:07
 */

use yii\helpers\Html;
use \yii\helpers\StringHelper;

?>

<div class="last-user-posts">
    <?php if (count($posts)): ?>
        <p>
            <?= Html::a('See All Posts', ['/user-posts/index', 'user_id' => $user->id]) ?>
        </p>
        <?php foreach ($posts as $post): ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <?= Html::a(Html::encode($post->tittle), ['/user-posts/view', 'user_id' => $post->user_id, 'id' => $post->id]) ?>
                </div>
                <div class="panel-body">
                    <?= \Yii::$app->formatter->asNtext(StringHelper::truncateWords($post->content, 50)) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Nothing found(((</p>
    <?php endif; ?>
</div>

