<?php

namespace common\models;

use common\models\setting\Base;
use common\models\setting\Mail;
use common\models\swp\Material;
use Yii;

/**
 * This is the model class for table "{{%notification}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $order_id
 * @property int $value
 * @property int $is_checked
 * @property int $type
 * @property int $created_at
 * @property Orders $order
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%notification}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'order_id'], 'required'],
            [['user_id', 'order_id', 'value', 'is_checked', 'type', 'created_at'], 'integer'],
            [['is_checked', 'type'], 'default', 'value' => 0],
            [['created_at'], 'default', 'value' => time()]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'order_id' => 'Order ID',
            'value' => 'Value',
            'is_checked' => 'Is Checked',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $user
     * @param null $slug
     * @return Notification[]
     */
    public static function getClientNotification($user, $slug = null) {
        $notifications =  self::find()->where(['user_id' => $user->id])
            ->andWhere(['type' => 0]);
        $notifications = $notifications->all();
        if ($slug && $category = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $slug)) {
            /** @var Notification $notification */
            foreach ($notifications as $key => $notification) {
                if ($notification->order->category_id != $category->id) {
                    unset($notification[$key]);
                }
            }
        }
        foreach ($notifications as $notification) {
            $notification->is_checked = 1;
            $notification->save();
        }
        return array_reverse($notifications);
    }

    /**
     * @param $user
     * @param null $slug
     * @return Notification[]
     */
    public static function getMasterNotification($user, $slug = null) {
        $notifications =  self::find()->where(['user_id' => $user->id])
            ->andWhere(['type' => 1]);
        $notifications = $notifications->all();
        if ($slug && $category = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $slug)) {
            /** @var Notification $notification */
            foreach ($notifications as $key => $notification) {
                if ($notification->order->category_id != $category->id) {
                    unset($notification[$key]);
                }
            }
        }
        foreach ($notifications as $notification) {
            $notification->is_checked = 1;
            $notification->save();
        }
        return array_reverse($notifications);
    }

    public static function getMasterCount($user) {
        $notifications = self::find()
            ->where(['user_id' => $user->id, 'is_checked' => 0])
            ->andWhere(['type' => 1]);
        return count($notifications->all());
    }

    public static function getClientCount($user) {
        $notifications = self::find()
            ->where(['user_id' => $user->id, 'is_checked' => 0])
            ->andWhere(['type' => 0]);
        return count($notifications->all());
    }

    public function getCreateDate()
    {
        return date('d/m/Y', $this->created_at);
    }

    /**
     * @param Orders $order
     */
    public static function assignMaster($order) {
        $notification = new Notification();
        $notification->user_id = $order->master_id;
        $notification->order_id = $order->id;
        $notification->type = 1;
        $notification->save();
        self::sendEmail($notification);
    }

    /**
     * @param MasterOrders $order
     */
    public static function masterRequest($order) {
        if ($notification = Notification::findOne(['user_id' => $order->order->client_id, 'order_id' => $order->order_id, 'is_checked' => 0, 'type' => 0])) {
            $notification->value = $notification->value + 1;
            $notification->save();
        } else {
            $notification = new Notification();
            $notification->user_id = $order->order->client_id;
            $notification->order_id = $order->order_id;
            $notification->type = 0;
            $notification->value = 1;
            $notification->save();
            self::sendEmail($notification);
        }
    }

    /**
     * @param Notification $notification
     * @return bool
     */
    private static function sendEmail($notification)
    {
        if ($notification->user->is_subscribe) {
            $supportEmail = Mail::instance()->login;
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'notification/html', 'text' => 'notification/text'],
                    ['model' => $notification]
                )
                ->setFrom([($supportEmail ? $supportEmail : Yii::$app->params['supportEmail']) => Base::instance()->title])
                ->setTo($notification->user->email)
                ->setSubject('Новое уведомление | ' . Base::instance()->title)
                ->send();
        }
        return false;
    }
}
