<?

namespace backend\controllers\common;

use Yii;
use yii\web\NotFoundHttpException;

abstract class CRUDController extends AdminController
{
    protected $mainClass;

    abstract public function actionIndex();

    abstract public function actionCreate();

    abstract public function actionUpdate($id);

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function delete($id)
    {
        $this->findModel($id)->delete();
    }

    /**
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionMultiDelete()
    {
        $this->multiDelete();
        return $this->redirect(['index']);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function multiDelete() {
        if($keyList = Yii::$app->request->post('keyList'))
        {
            $arrKey = explode(',', $keyList);
            foreach ($arrKey as $item) {
                $this->delete($item);
            }
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ($this->mainClass)::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException();
    }

    /**
     * @param $post
     * @param $model
     * @return bool
     */
    protected function checkSubmitType($post, $model)
    {
        if (isset($post['save'])) {
            $this->submitSave($model, $post['tab']);
        }
        if (isset($post['save-close'])) {
            $this->submitSaveClose($model);
        }
        if (isset($post['save-create'])) {
            $this->submitSaveCreate($model);
        }
        if (isset($post['save-copy'])) {
            $this->submitSaveCopy($model);
        }
        return false;
    }

    /**
     * @param $model
     * @param $tab
     * @return \yii\web\Response
     */
    protected function submitSave($model, $tab) {
        return $this->redirect(['update', 'id' => $model->id, 'tab' => $tab ? $tab : null]);
    }

    /**
     * @param $model
     * @return \yii\web\Response
     */
    protected function submitSaveClose($model) {
        return $this->redirect(['index']);
    }

    /**
     * @param $model
     * @return \yii\web\Response
     */
    protected function submitSaveCreate($model) {
        return $this->redirect(['create']);
    }

    /**
     * @param $model
     * @return \yii\web\Response
     */
    protected function submitSaveCopy($model) {
        return $this->redirect(['create', 'copy' => $model->id]);
    }

    protected function successSave() {
        Yii::$app->session->setFlash('success', 'Элемент успешно сохранён');
    }
}
