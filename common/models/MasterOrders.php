<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%master_orders}}".
 *
 * @property int $id
 * @property int $order_id
 * @property int $user_id
 * @property User $user
 * @property Orders $order
 */
class MasterOrders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%master_orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id'], 'required'],
            [['order_id', 'user_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'user_id' => 'User ID',
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getOrder() {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }
}
