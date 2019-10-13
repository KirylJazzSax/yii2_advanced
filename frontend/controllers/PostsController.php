<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.10.2019
 * Time: 18:50
 */

namespace frontend\controllers;


use frontend\models\search\PostSearch;
use yii\web\Controller;

class PostsController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}