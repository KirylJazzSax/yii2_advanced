<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.10.2019
 * Time: 20:38
 */
namespace console\controllers;

use common\Rbac\Rbac;
use common\rbac\rules\PostAuthorRule;
use common\rbac\rules\ProfileOwnerRule;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $rule = new ProfileOwnerRule();
        $auth->add($rule);

        $manageProfile = $auth->createPermission(Rbac::MANAGE_PROFILE);
        $manageProfile->ruleName = $rule->name;
        $auth->add($manageProfile);

        $ruleAuthor = new PostAuthorRule();
        $auth->add($ruleAuthor);

        $managePost = $auth->createPermission(Rbac::MANAGE_POST);
        $managePost->ruleName = $ruleAuthor->name;
        $auth->add($managePost);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $manageProfile);
        $auth->addChild($user, $managePost);
    }
}