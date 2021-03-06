<?php

namespace backend\modules\swp\controllers;

use backend\modules\swp\controllers\common\CRUDController;
use backend\modules\swp\models\Material;
use backend\modules\swp\models\Group;
use common\models\swp\search\Material as MaterialSearch;
use yii\web\NotFoundHttpException;

class MaterialController extends CRUDController
{
    public function init()
    {
        $this->mainClass = Material::className();
        $this->searchClass = MaterialSearch::className();
        $this->parentController = '/swp/material';
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     * @param null $tab
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionIndex($group = 0, $tab = null)
    {
        if (!$group) {
            throw new NotFoundHttpException();
        }
        $groupModel = Group::findOne($group);
        if ($groupModel) {
            if ($groupModel->is_singleton) {
                if ($model = $groupModel->materials[0]) {
                    return $this->redirect(['update', 'id' => $model->id, 'tab' => $tab]);
                } else {
                    return $this->redirect(['create', 'group' => $group, 'tab' => $tab]);
                }
            }
        } else {
            throw new NotFoundHttpException();
        }
        return parent::actionIndex($group); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     * @param null $id
     * @return bool|string|\yii\web\Response
     */
    public function actionCreate($group = null, $copy = null, $tab = null, $id = null)
    {
        if (!$group) {
            throw new NotFoundHttpException();
        }
        $groupModel = Group::findOne($group);
        if ($groupModel) {
            if ($groupModel->is_singleton) {
                if ($model = $groupModel->materials[0]) {
                    return $this->redirect(['update', 'id' => $model->id, 'tab' => $tab]);
                }
            } else {
                if ($groupModel->group && !$id) {
                    throw new NotFoundHttpException();
                }
            }
            if ($groupModel->type == 0) {
                throw new NotFoundHttpException();
            }
        } else {
            throw new NotFoundHttpException();
        }
        return parent::actionCreate($group, $copy, $tab); // TODO: Change the autogenerated stub
    }

    /**
     * @param $model Material
     * {@inheritdoc}
     */
    protected function submitSaveClose($model)
    {
        $group = $model->group;
        if ($model->material_id) {
            return $this->redirect([$this->parentController.'/update', 'id' => $model->getMaterialParent()->id, 'tab' => 'group'.$group->id]);
        }
        return $this->redirect(['index', 'group' => $group->id]);
    }

    /**
     * @param $model Material
     * {@inheritdoc}
     */
    protected function submitSaveCreate($model)
    {
        $this->redirect(['create', 'id' => $model->getMaterialParent()->id, 'group' => $model->group->id]);
    }

    /**
     * @param $model Material
     * {@inheritdoc}
     */
    protected function submitSaveCopy($model)
    {
        $this->redirect(['create', 'id' => $model->getMaterialParent()->id, 'group' => $model->group->id, 'copy' => $model->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionMultiDelete($group = null, $tab = null)
    {
        if (!$tab) {
            $groupModel = Group::findOne($group);
            if (!$groupModel->group_id) {
                $this->multiDelete();
                return $this->redirect([$this->parentController.'/index', 'group' => $group]);
            }
        }
        return parent::actionMultiDelete($group, $tab);
    }
}
