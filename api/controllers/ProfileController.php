<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 05.10.2019
 * Time: 22:10
 */

namespace api\controllers;

use common\models\User;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\Controller;
use yii\web\ServerErrorHttpException;

class ProfileController extends Controller
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['authMethods'] = [
            HttpBasicAuth::class,
            HttpBearerAuth::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ]
        ];

        return $behaviors;
    }

    public function actionIndex()
    {
        return $this->findModel();
    }

    public function actionUpdate()
    {
        $model = $this->findModel();

        $model->load(\Yii::$app->request->getBodyParams(), '');

        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Not working');
        }

        return $model;
    }

    public function verbs()
    {
        return [
            'index' => ['get'],
            'update' => ['patch', 'put']
        ];
    }

    private function findModel()
    {
        return User::findOne(\Yii::$app->user->id);
    }
}