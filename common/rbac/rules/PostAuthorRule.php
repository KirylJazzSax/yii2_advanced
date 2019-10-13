<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2019
 * Time: 21:19
 */

namespace common\rbac\rules;


use yii\base\InvalidCallException;
use yii\rbac\Item;
use yii\rbac\Rule;

class PostAuthorRule extends Rule
{
    public $name = 'postAuthor';
    /**
     * Executes the rule.
     *
     * @param string|int $user the user ID. This should be either an integer or a string representing
     * the unique identifier of a user. See [[\yii\web\User::id]].
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to [[CheckAccessInterface::checkAccess()]].
     * @return bool a value indicating whether the rule permits the auth item it is associated with.
     */
    public function execute($user, $item, $params)
    {
        if (empty($params['post'])) {
            throw new InvalidCallException('Need post!!!');
        }

        return $params['post']->user_id == $user;
    }
}