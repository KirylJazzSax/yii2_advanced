<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2019
 * Time: 19:02
 */

namespace frontend\widgets;


use common\models\User;
use frontend\models\Post;
use yii\base\InvalidConfigException;
use yii\base\Widget;

class LastUserPosts extends Widget
{
    public $user;
    public $limit = 10;

    public function init()
    {
        if (!$this->user || !$this->user instanceof User) {
            throw new InvalidConfigException('Empty  Post!');
        }
    }

    public function run()
    {
        return $this->render('last-user-posts', [
            'user' => $this->user,
            'posts' => Post::find()->forUser($this->user->id)->latest($this->limit)->all(),
        ]);
    }
}