<?php

namespace backend\controllers;

use backend\controllers\common\CRUDController;
use common\models\search\Orders;
use Yii;
use yii\web\NotFoundHttpException;

class OrderController extends CRUDController
{
    protected $mainClass = "common\models\Orders";
    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new Orders();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->save()) {
            $this->successSave();
            return $this->checkSubmitType($post, $model);
        }

        return $this->render('update', [
            'model' => $model,
            'tab' => $tab
        ]);
    }

    public function actionMultiDelete($id = null)
    {
        if ($id) {
            $this->multiDelete();
            return $this->redirect(['user/update', 'id' => $id, 'tab' => 'sub-order']);
        }
        return parent::actionMultiDelete();
    }

    /**
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        throw new NotFoundHttpException();
    }
}
