<?php
namespace frontend\controllers;

use common\models\MasterOrders;
use common\models\Notification;
use common\models\Orders;
use common\models\Review;
use common\models\User;
use frontend\models\cabinet\Order;
use frontend\models\cabinet\UserEditForm;
use frontend\models\ContactForm;
use Imagine\Image\Box;
use Imagine\Image\Point;
use Yii;
use yii\base\Exception;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class CabinetController extends Controller
{

    public $layout = 'cabinet';
    public $is_client = true;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'select-order-master' => ['post'],
                ],
            ],
        ];
    }

    public function actionClient($send = null) {
        $user = User::findOne(Yii::$app->user->id);
        if ($send) {
            if ($send == 1) {
                Yii::$app->session->setFlash('photoUpdated');
            }
            return $this->redirect('client');
        }
        return $this->render('client/index', [
            'user' => $user,
        ]);
     }

    public function actionMaster() {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        return $this->render('master/index', [
            'user' => $user,
        ]);
    }

    /**
     * @param null $slug
     * @return bool|string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreateOrder($slug = null) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            $model = new Order();
            if ($model->load(Yii::$app->request->post()) && $model->createOrder($user)) {
                return $this->redirect('client-orders');
            }
            $model->category = $slug;
            return $this->render('client/order', [
                'user' =>$user,
                'model' => $model,
            ]);
        } else {
            return $this->redirect('client');
        }
    }

    /**
     * @param $id
     * @return bool|string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdateOrder($id) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            if ($order = Orders::findOne($id)) {
                if ($order->client_id == $user->id) {
                    $model = Order::getForm($order);
                    if ($model->load(Yii::$app->request->post()) && $model->updateOrder($user, $order)) {
                        return $this->redirect('client-orders');
                    }
                    return $this->render('client/order', [
                        'user' =>$user,
                        'model' => $model,
                    ]);
                }
            }
        } else {
            return $this->redirect('client');
        }
    }

    /**
     * @param $id
     * @return bool|string|\yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteOrder($id) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            if ($order = Orders::findOne($id)) {
                if ($order->client_id == $user->id) {
                    $order->delete();
                }
            }
            return $this->redirect('client-orders');
        } else {
            return $this->redirect('client');
        }
    }

    public function actionSearchOrder($slug = null) {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_master) {
            return $this->render('master/search-order', [
                'user' =>$user,
                'orders' => $user->getFreeOrders($slug),
                'slug' => $slug,
            ]);
        } else {
            return $this->redirect('master');
        }
    }

    public function actionClientNotification($slug = null) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            return $this->render('client/notification', [
                'user' =>$user,
                'slug' => $slug,
            ]);
        } else {
            return $this->redirect('client');
        }
    }

    public function actionMasterNotification($slug = null) {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_master) {
            return $this->render('master/notification', [
                'user' =>$user,
                'slug' => $slug,
            ]);
        } else {
            return $this->redirect('master');
        }
    }

    public function actionClientOrders($slug = null) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            return $this->render('client/orders', [
                'user' =>$user,
                'slug' => $slug,
            ]);
        } else {
            return $this->redirect('client');
        }
    }

    public function actionMasterOrders($slug = null) {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_master) {
            return $this->render('master/orders', [
                'user' =>$user,
                'slug' => $slug,
            ]);
        } else {
            return $this->redirect('master');
        }
    }

    public function actionClientService() {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client) {
            return $this->render('common/service', [
                'user' =>$user
            ]);
        } else {
            return $this->redirect('client');
        }
    }

    public function actionMasterService() {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_master) {
            return $this->render('common/service', [
                'user' =>$user
            ]);
        } else {
            return $this->redirect('master');
        }
    }

    public function actionSupport($type = null) {
        $user = User::findOne(Yii::$app->user->id);
        $model = new ContactForm();
        $model->user = $user;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Спасибо, ваша заявка принята! Мы свяжемся с вами в ближайшее время.');
            } else {
                Yii::$app->session->setFlash('error', 'Возникла проблема при отправке сообщения. Пожалуйста, попробуйте позже');
            }
        }
        if ($type == 'master') {
            $this->is_client = false;
            if ($user->is_master) {
                return $this->render('common/support', [
                    'user' =>$user,
                    'model' => $model
                ]);
            } else {
                return $this->redirect('master');
            }
        } else {
            if ($user->is_client) {
                return $this->render('common/support', [
                    'user' =>$user,
                    'model' => $model
                ]);
            } else {
                return $this->redirect('client');
            }
        }
    }

    public function actionClientOrderView($id) {
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_client && $model = Orders::findOne($id)) {
            return $this->render('client/order-view', [
                'user' =>$user,
                'model' => $model,
            ]);
        } else {
            return $this->redirect('client');
        }
    }

    public function actionMasterOrderView($id) {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        $order = Orders::findOne($id);
        if ($user->is_master && $order && $order->client_id != $user->id) {
            return $this->render('master/order-view', [
                'user' =>$user,
                'model' => $order,
            ]);
        } else {
            return $this->redirect('master');
        }
    }

    public function actionMasterRequest($id) {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        $order = Orders::findOne($id);
        if ($user->is_master && $order && !$order->master_id && $order->client_id != $user->id) {
            $master_order = new MasterOrders();
            $master_order->order_id = $order->id;
            $master_order->user_id = $user->id;
            $master_order->save();
            Notification::masterRequest($master_order);
            return $this->redirect('master-orders');
        } else {
            return $this->redirect('master');
        }
    }

    public function actionSelectOrderMaster($id, $master_id) {
        $user = User::findOne(Yii::$app->user->id);
        $order = Orders::findOne($id);
        if ($user->is_client && $order && $order->client_id == $user->id && !$order->master_id) {
            $order->assignMaster($master_id);
            return $this->redirect(['client-order-view', 'id' => $id]);
        } else {
            return $this->redirect('client');
        }
    }

    public function actionBecomeClient() {
        $user = User::findOne(Yii::$app->user->id);
        $user->becomeRole();
        return $this->redirect('client');
    }

    public function actionBecomeMaster() {
        $user = User::findOne(Yii::$app->user->id);
        $user->becomeRole(true);
        return $this->redirect('master');
    }

    public function actionProfileEdit($type = null) {
        if ($type) {
            $this->is_client = false;
        }
        $user = User::findOne(Yii::$app->user->id);
        $model = UserEditForm::getForm($user);
        if ($model->load(Yii::$app->request->post()) && $model->updateUser($user)) {
            Yii::$app->session->setFlash('success', 'Изменения успешно сохранены.');
        }
        return $this->render('common/profile-edit', [
            'user' => $user,
            'model' => $model,
        ]);
    }

    public function actionGeoMasters($slug = null, $exclude = null) {
        $user = User::findOne(Yii::$app->user->id);
        if (Yii::$app->request->isAjax) {
            $slug = array_pop(explode(',', $exclude));
            return $this->renderAjax('elements/geo-masters',[
                'user' => $user,
                'masters' => $user->getGeoMasters($slug, $exclude),
            ]);
        }
        if ($user->is_client) {
            return $this->render('client/geo-masters', [
                'user' => $user,
                'masters' => $user->getGeoMasters($slug),
                'slug' => $slug,
            ]);
        } else {
            $this->redirect(['client']);
        }
    }

    public function actionMasterPortfolio() {
        $this->is_client = false;
        $user = User::findOne(Yii::$app->user->id);
        if ($user->is_master) {
            return $this->render('master/portfolio', [
                'user' => $user,
                'files_add' => $user->info->getPortfolioImages(),
            ]);
        }
        return $this->redirect(['master']);
    }

    /**
     * @return bool
     */
    public function actionDeletePortfolio()
    {
        $user = User::findOne(Yii::$app->user->id);
        if (Yii::$app->request->isPost) {
            $file = Yii::$app->request->post('file');
            $path = Yii::getAlias('@frontend/web/uploads/users/' . $user->id . '/portfolio/' . $file);
            if (file_exists($path)) {
                @unlink($path);
                return true;
            }
        }
        return false;
    }

    public function actionPortfolioUpload()
    {
        $user = User::findOne(Yii::$app->user->id);
        $num = count($user->info->getPortfolioFiles()) + 1;
        if ($num >= 6) {
            return json_encode(['error' => 'Количество выбранных файлов превышает максимально допустимое количество 5.']);
        }
        if (Yii::$app->request->isPost) {
            $path = Yii::getAlias('@frontend/web/uploads/users/' . $user->id . '/portfolio');
            try {
                BaseFileHelper::createDirectory($path);
                $file = UploadedFile::getInstancesByName('portfolio');
                if ($file) {
                    $name = 'tmp.'.$file->extension;
                    $file[0]->saveAs($path . DIRECTORY_SEPARATOR . $name);
                    $image = $path . DIRECTORY_SEPARATOR . $name;
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
                    $imageGeneral->save($image, ['jpeg_quality' => 100]);

                    $new_name = $path . DIRECTORY_SEPARATOR . $num.'.jpg';

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
                        ->resize(new Box(180, 180))
                        ->save($new_name, ['jpeg_quality' => 100]);
                    @unlink($path . DIRECTORY_SEPARATOR . $name);
                    return true;
                }
            } catch (Exception $e) {}
        }
        return false;
    }

    public function actionMasterView($id) {
        $user = User::findOne(Yii::$app->user->id);
        $master = User::findOne($id);
        if ($master->is_master) {
            $review = null;
            if ($user->allowReview($master)) {
                $review = new Review();
                if ($review->load(Yii::$app->request->post())) {
                    $review->author_id = $user->id;
                    $review->user_id = $master->id;
                    if ($review->save()) {
                        Yii::$app->session->setFlash('success', 'Ваш отзыв успешно опубликован.');
                        $review = null;
                    }
                }
            }
            return $this->render('master/index', [
                'user' => $master,
                'is_view' => true,
                'review' => $review,
            ]);
        } else {
            return $this->goBack();
        }
    }

    /**
     * @param $id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteReview($id) {
        $user = User::findOne(Yii::$app->user->id);
        $review = Review::findOne($id);
        if ($review->user_id = $user->id) {
            $review->delete();
        }
        $this->redirect('master');
    }
}
