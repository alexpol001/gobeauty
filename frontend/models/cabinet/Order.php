<?php
namespace frontend\models\cabinet;

use common\models\Orders;
use common\models\setting\Base;
use common\models\setting\Mail;
use common\models\swp\Material;
use frontend\components\Frontend;
use Yii;
use yii\base\Model;
use common\models\User;

class Order extends Model
{
    public $category;
    public $description;
    public $date;
    public $time;
    public $place;
    public $street;
    public $house;
    public $room;
    public $housing;
    public $pay_method;
    public $price;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'date', 'time', 'place', 'pay_method', 'price', 'description'], 'required'],
            [['place', 'price', 'pay_method'], 'integer'],
            [['street', 'house', 'room', 'housing'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['street', 'house', 'room', 'housing', 'description'], 'trim'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category' => 'Категория',
            'description' => 'Описание',
            'date' => 'Дата',
            'time' => 'Время',
            'place' => 'Место',
            'street' => 'Улица',
            'house' => 'Дом',
            'room' => 'Квартира',
            'housing' => 'Корпус',
            'pay_method' => 'Способ оплаты',
            'price' => 'Цена',
        ];
    }

    /**
     * @param Orders $order
     * @return Order
     */
    public static function getForm($order) {
        $orderForm = new self();
        $orderForm->category = Material::findOne($order->category_id)->slug;
        $orderForm->description = $order->description;
        $orderForm->date = date('Y-m-d', $order->date);;
        $orderForm->time = $order->getDateTime();
        $orderForm->place = $order->place;
        $orderForm->pay_method = $order->pay_method;
        $orderForm->price = $order->price;
        return $orderForm;
    }

    /**
     * @param User $client
     * @param Orders $order
     * @return bool
     * @throws \Exception
     */
    public function updateOrder($client, $order) {
        if ($this->validate()) {
            $order->category_id = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $this->category)->id;
            $order->description = $this->description;
            $order->date = (new \DateTime($this->date.'T'.$this->time))->getTimestamp();
            if ($order->date < time() || $order->date > time() + 60*60*24*7*365) {
                return false;
            }
            $order->place = $this->place;
            $order->pay_method = $this->pay_method;
            $order->price = $this->price;
            if ($order->save()) {
                $client->info->street = $this->street;
                $client->info->house = $this->house;
                $client->info->room = $this->room;
                $client->info->housing = $this->housing;
                $client->info->save();
                return true;
            }
        }
        return false;
    }

    /**
     * @param User $client
     * @return bool
     * @throws \Exception
     */
    public function createOrder($client) {
        if ($this->validate()) {
            $order = new Orders();
            $order->client_id = $client->id;
            $order->category_id = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $this->category)->id;
            $order->description = $this->description;
            $order->date = (new \DateTime($this->date.'T'.$this->time))->getTimestamp();
            if ($order->date < time()|| $order->date > time() + 60*60*24*7*365) {
                return false;
            }
            $order->place = $this->place;
            $order->pay_method = $this->pay_method;
            $order->price = $this->price;

            if (Base::instance()->noModeration) {
                $order->status = 1;
            }

            if ($order->save()) {
                $client->info->street = $this->street;
                $client->info->house = $this->house;
                $client->info->room = $this->room;
                $client->info->housing = $this->housing;
                $client->info->save();
                $this->sendEmail($order);
                return true;
            }
        }
        return false;
    }

    public function sendEmail($order)
    {
        if (!Base::instance()->noModeration) {
            $supportEmail = Mail::instance()->login;
            return Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'new-order/html', 'text' => 'new-order/text'],
                    ['model' => $order]
                )
                ->setFrom([($supportEmail ? $supportEmail : Yii::$app->params['supportEmail']) => Base::instance()->title])
                ->setTo($supportEmail)
                ->setSubject('Новый заказ ожидает модерации | ' . Base::instance()->title)
                ->send();
        }
    }
}
