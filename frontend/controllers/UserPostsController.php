<?php

namespace frontend\controllers;

use common\Rbac\Rbac;
use common\models\User;
use Yii;
use frontend\models\Post;
use frontend\models\search\PostSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostsController implements the CRUD actions for Post model.
 */
class UserPostsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param $user_id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionIndex($user_id)
    {
        $user = $this->findUserModel($user_id);

        $dataProvider = new ActiveDataProvider([
            'query' => Post::find()->forUser($user->id)->orderBy(['id' => SORT_DESC]),
        ]);

        return $this->render('index', [
            'user' => $user,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $user_id
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($user_id, $id)
    {
        return $this->render('view', [
            'user' => $this->findUserModel($user_id),
            'model' => $this->findPostModel($user_id, $id),
        ]);
    }

    /**
     * @param $user_id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionCreate($user_id)
    {
        $user = $this->findUserModel($user_id);

        if ($user->id != \Yii::$app->user->id) {
            throw new ForbiddenHttpException('Sorry...');
        }

        $model = new Post();
        $model->user_id = $user_id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $user->id, 'id' => $model->id]);
        }

        return $this->render('create', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id
     * @param $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($user_id, $id)
    {
        $user = $this->findUserModel($user_id);
        $model = $this->findPostModel($user_id, $id);

        if (!\Yii::$app->user->can(Rbac::MANAGE_POST, ['post' => $model])) {
            throw new ForbiddenHttpException('Sorry...');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'user_id' => $user->id, 'id' => $model->id]);
        }

        return $this->render('update', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    /**
     * @param $user_id
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($user_id, $id)
    {
        $user = $this->findUserModel($user_id);
        $model = $this->findPostModel($user_id, $id);

        if (!\Yii::$app->user->can(Rbac::MANAGE_POST, ['post' => $model])) {
            throw new ForbiddenHttpException('Sorry...');
        }
        $model->delete();

        return $this->redirect(['index', 'user_id' => $user->id]);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPostModel($user_id, $id)
    {
        if (($model = Post::find()->forUser($user_id)->andWhere(['id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested post does not exist.');
    }

    /**
     * @param $user_id
     * @return User|null
     * @throws NotFoundHttpException
     */
    protected function findUserModel($user_id)
    {
        if (($model = User::findOne($user_id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Sorry user does not exist...');

    }
}
