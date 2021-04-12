<?php

namespace common\models;

use common\components\Common;
use common\models\swp\Group;
use common\models\swp\Material;
use frontend\components\Frontend;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property int $id
 * @property int $client_id
 * @property int $category_id
 * @property int $master_id
 * @property string $description
 * @property string $date
 * @property int $place
 * @property int $pay_method
 * @property int $price
 * @property int $status
 * @property User $master
 * @property User $client
 * @property MasterOrders[] $mOrders
 * @property Notification[] $notifications
 */
class Orders extends \yii\db\ActiveRecord
{

    const CATEGORY_GROUP = 7;

    private static $places = [
        '0' => 'У меня',
        '1' => 'У исполнителя',
        '2' => 'Неважно',
    ];

    private static $pay_methods = [
        '0' => 'Наличный',
        '1' => 'Безналичный',
    ];

    private static $statuses = [
        '0' => 'На модерации',
        '1' => 'Активен',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['client_id', 'category_id', 'description', 'date', 'price', 'pay_method'], 'required'],
            [['client_id', 'category_id', 'master_id', 'place', 'price', 'date', 'pay_method', 'status'], 'integer'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Клиент',
            'category_id' => 'Категория',
            'master_id' => 'Мастер',
            'description' => 'Описание',
            'date' => 'Дата и время',
            'place' => 'Место',
            'price' => 'Цена',
            'pay_method' => 'Способ оплаты',
            'status' => 'Статус'
        ];
    }

    public function getClient()
    {
        return $this->hasOne(User::className(), ['id' => 'client_id']);
    }

    public function getMaster()
    {
        return $this->hasOne(User::className(), ['id' => 'master_id']);
    }

    public function getMOrders()
    {
        return $this->hasMany(MasterOrders::className(), ['order_id' => 'id']);
    }

    /**
     * @return User[]
     */
    public function getMasters()
    {
        $masters = User::find();
        if ($orders = $this->mOrders) {
            foreach ($orders as $order) {
                $masters = $masters->orWhere(['id' => $order->user_id]);
            }
        } else {
            $masters = $masters->andWhere(['id' => 0]);
        }
        return $masters->all();
    }

    /**
     * @return Material|null
     */
    public function getCategory()
    {
        return Material::findOne(['id' => $this->category_id]);
    }

    public function getDateDate()
    {
        return date('d/m/Y', $this->date);
    }

    public function getDateTime()
    {
        return date('h:i', $this->date);
    }


    public function getPlaceName()
    {
        return self::$places[$this->place];
    }

    public function getPaymentName()
    {
        return self::$pay_methods[$this->pay_method];
    }

    public function getNotifications() {
        return $this->hasMany(Notification::className(), ['order_id' => 'id']);
    }

    public function getFormattedPrice()
    {
        return number_format($this->price, 0, '', ' ') . ' ₽';
    }

    public function assignMaster($master_id)
    {
        if (!$this->master_id) {
            $this->master_id = $master_id;
            if ($this->save()) {
                MasterOrders::deleteAll(['order_id' => $this->id]);
                Notification::assignMaster($this);
                return true;
            }
        }
        return false;
    }

    public static function getStatuses()
    {
        return self::$statuses;
    }

    public function getStatusName()
    {
        return self::$statuses[$this->status];
    }

    public static function getPlaces()
    {
        return self::$places;
    }

    public static function getPaymentList()
    {
        return self::$pay_methods;
    }

    /**
     * @param null|Orders[] $orders
     * @return \common\models\swp\Material[]
     */
    public static function getCategories($orders = null)
    {
        $result = Group::findOne(self::CATEGORY_GROUP)->materials;
        if ($orders) {
            foreach ($result as $key => $category) {
                $hasCategory = false;
                foreach ($orders as $order) {
                    if ($category->id == $order->getCategory()->id) {
                        $hasCategory = true;
                        break;
                    }
                }
                if (!$hasCategory) {
                    unset($result[$key]);
                }
            }
        }
        return $result;
    }

    public static function getCategoryList($header = null)
    {
        $array = [];
        if ($header) {
            $array[""] = $header;
        }
        foreach (self::getCategories() as $category) {
            $array[$category->slug] = $category->title;
        }
        return $array;
    }

    public static function getCategoryArray()
    {
        $array = [];
        foreach (self::getCategories() as $category) {
            $array[$category->id] = $category->title;
        }
        return $array;
    }

    /**
     * @param $category_id
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function deleteByCategory($category_id) {
        Common::deleteAll(self::findAll(['category_id' => $category_id]));
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        Common::deleteAll($this->mOrders);
        Common::deleteAll($this->notifications);
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }
}
