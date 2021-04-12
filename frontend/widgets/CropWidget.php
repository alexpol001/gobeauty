<?php

namespace frontend\widgets;


use frontend\controllers\CabinetController;
use frontend\widgets\models\PhotoForm;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\base\Widget;
use yii\imagine\Image;

/** @property CabinetController $controller */
class CropWidget extends Widget
{
    public $user;
    public $controller;
    public function run()
    {
        $model = new PhotoForm($this->user);
        if ($this->cropPhoto($model)) {
            $action = Yii::$app->controller->action->id;
            $this->controller->redirect([$action,
                'send' => 2
            ]);
        }
        return $this->render('crop/index', [
            'model' => $model,
        ]);
    }

    /**
     * @param PhotoForm $model
     * @return bool
     */
    public function cropPhoto($model) {
        $post = Yii::$app->request->post();
        if ($post['crop'] && $model->user && $model->load($post)) {
            $id = $model->user->id;
            $path = Yii::getAlias("@frontend/web/uploads/users/".$id."/general");
            $image = $path.DIRECTORY_SEPARATOR.'general.jpg';
            $points = explode(', ', $model->photo_points);
            if (file_exists($image) && count($points) == 4) {
                $new_name = $path .DIRECTORY_SEPARATOR."small_general.jpg";
                $x1 = $points[0];
                $y1 = $points[1];
                $x2 = $points[2];
                $y2 = $points[3];
                Image::frame($image, 0, 'fff', 0)
                    ->crop(new Point($x1, $y1), new Box($x2-$x1, $y2-$y1))
                    ->resize(new Box(130,130))
                    ->save($new_name, ['quality' => 100]);
                return $model->user->info->setPhotoPoints($x1, $y1, $x2, $y2);
            }
        }
        return false;
    }
}
