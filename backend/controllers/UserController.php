<?php

namespace backend\controllers;

use backend\controllers\common\CRUDController;
use backend\models\UserForm;
use Yii;
use common\models\User;
use common\models\search\User as UserSearch;
use yii\web\NotFoundHttpException;

class UserController extends CRUDController
{
    protected $mainClass = "common\models\User";
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new UserForm(new User());
        $model->setScenario(UserForm::SCENARIO_CREATE);
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->create()) {
            $this->successSave();
            return $this->checkSubmitType($post, $model->_user);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * @param $id
     * @param $tab
     * @return bool|string
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate($id, $tab = null)
    {
        $model = new UserForm($this->findModel($id));

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->update()) {
            $this->successSave();
            return $this->checkSubmitType($post, $model->_user);
        }

        return $this->render('update', [
            'model' => $model,
            'tab' => $tab
        ]);
    }
}
