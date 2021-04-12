<?php
namespace frontend\models\cabinet;

use common\models\Orders;
use common\models\swp\Material;
use common\models\User;
use yii\base\Model;

class UserEditForm extends Model
{
    public $name;
    public $description;
    public $city;
    public $street;
    public $house;
    public $room;
    public $housing;
    public $phone;
    public $is_client;
    public $is_master;
    public $is_subscribe;
    public $categories;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_client', 'is_master', 'is_subscribe'], 'integer'],
            [['name', 'city', 'street', 'house', 'room', 'housing', 'phone'], 'string', 'max' => 255],
            [['phone'], 'match', 'pattern' => '/^\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/', 'message' => 'Неверный формат сотового телефона'],
            [['description'], 'string'],
            [['name', 'street', 'house', 'room', 'housing', 'description'], 'trim'],
            ['categories', 'each', 'rule' => ['string']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя и фамилия',
            'description' => 'Описание',
            'city' => 'Город',
            'phone' => 'Номер телефона',
            'street' => 'Улица',
            'house' => 'Дом',
            'room' => 'Квартира',
            'housing' => 'Корпус',
            'is_client' => 'Клиент',
            'is_master' => 'Мастер',
            'is_subscribe' => 'Получать Email-уведомления',
            'categories' => 'Выберите категории, в которых вы работаете',
        ];
    }

    /**
     * @param User $user
     * @return UserEditForm
     */
    public static function getForm($user) {
        $orderForm = new self();
        $orderForm->name = $user->info->name;
        $orderForm->description = $user->info->description;
        $orderForm->city = $user->info->city;
        $orderForm->street = $user->info->street;
        $orderForm->house = $user->info->house;
        $orderForm->room = $user->info->room;
        $orderForm->housing = $user->info->housing;
        $orderForm->phone = $user->info->phone;
        $orderForm->is_client = $user->is_client;
        $orderForm->is_master = $user->is_master;
        $orderForm->is_subscribe = $user->is_subscribe;
        foreach (explode(', ', $user->info->categories) as $id) {
            $orderForm->categories[] = Material::findOne($id)->slug;
        }
        return $orderForm;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function updateUser($user) {
        if ($this->validate()) {
            $user->info->name = $this->name;
            $user->info->description = $this->description;
            $user->info->city = $this->city;
            $user->info->street = $this->street;
            $user->info->house = $this->house;
            $user->info->room = $this->room;
            $user->info->housing = $this->housing;
            $user->info->phone = $this->phone;
            if ($this->categories) {
                foreach ($this->categories as $key => $category) {
                    if ($key) {
                        $user->info->categories .= ', ';
                    } else {
                        $user->info->categories = '';
                    }
                    $user->info->categories .= Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $category)->id;
                }
            }
            if ($user->info->save()) {
                $user->is_client = $this->is_client;
                $user->is_master = $this->is_master;
                $user->is_subscribe = $this->is_subscribe;
                if ($user->save()) {
                    return true;
                }
            }
        }
        return false;
    }
}
