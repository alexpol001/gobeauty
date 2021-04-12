<?php

namespace frontend\widgets;


use frontend\controllers\CabinetController;
use frontend\widgets\models\PhotoForm;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\base\Exception;
use yii\base\Widget;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

/** @property CabinetController $controller */
class PhotoWidget extends Widget
{
    public $user;
    public $controller;

    public function run()
    {
        $model = new PhotoForm($this->user);
        if ($this->uploadPhoto($model)) {
            $action = Yii::$app->controller->action->id;
            $this->controller->redirect([$action,
                'send' => 1
            ]);
        }
        return $this->render('photo/index', [
            'model' => $model,
        ]);
    }

    /**
     * @param PhotoForm $model
     * @return bool
     */
    public function uploadPhoto($model)
    {
        if (Yii::$app->request->post()['upload'] && $model->user) {
            $id = $model->user->id;
            $path = Yii::getAlias("@frontend/web/uploads/users/" . $id . "/general");
            try {
                BaseFileHelper::createDirectory($path);
            } catch (Exception $e) {
            }

            $file = UploadedFile::getInstance($model, 'file');
            $name = 'tmp.' . $file->getExtension();
            $file->saveAs($path . DIRECTORY_SEPARATOR . $name);

            $image = $path . DIRECTORY_SEPARATOR . $name;

            try {
                $imageGeneral = Image::getImagine()->open($image);

                $exif = @exif_read_data($image);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $imageGeneral->rotate(180);
                            break;
                        case 6:
                            $imageGeneral->rotate(90);
                            break;

                        case 8:
                            $imageGeneral->rotate(-90);
                            break;
                    }
                }
                $size = explode('x', str_replace(' px', '', $imageGeneral->getSize()));
                if ($size[0] > 720) {
                    $k = $size[0] / 720;
                    $width = 720;
                    $height = $size[1] / $k;
                    $imageGeneral->resize(new Box($width, $height));
                }
                $image = $path . DIRECTORY_SEPARATOR . 'general.jpg';
                $imageGeneral->save($image, ['jpeg_quality' => 100]);
                @unlink($path . DIRECTORY_SEPARATOR . $name);

                $new_name = $path . DIRECTORY_SEPARATOR . "small_general.jpg";

                $size = getimagesize($image);
                $width = $size[0];
                $height = $size[1];

                $y1 = floor(($height - $width) / 2) + 1;
                $x1 = floor(($width - $height) / 2) + 1;
                $y1 = $y1 < 0 ? 0 : $y1;
                $x1 = $x1 < 0 ? 0 : $x1;
                $x2 = $width - $x1;
                $y2 = $height - $y1;

                Image::frame($image, 0, 'fff', 0)
                    ->crop(new Point($x1, $y1), new Box($x2, $y2))
                    ->resize(new Box(130, 130))
                    ->save($new_name, ['jpeg_quality' => 100]);
                return $model->user->info->setPhotoPoints($x1, $y1, $x2, $y2);
            } catch (\Exception $e) {
                @unlink($path . DIRECTORY_SEPARATOR . $name);
                return false;
            }
        }
        return false;
    }
}
