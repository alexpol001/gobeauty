<?php
namespace backend\models;

use yii\base\Model;
use common\models\User;

/**
 * User form
 * @property User $_user
 */
class UserForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;
    public $is_client;
    public $is_master;
    public $is_subscribe;

    public $name;
    public $description;
    public $city;
    public $street;
    public $house;
    public $room;
    public $housing;
    public $phone;

    public $_user;

    const SCENARIO_CREATE = 'create';

    public function __construct($user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['email','password','password_repeat', 'is_client', 'is_master', 'is_subscribe'];//Scenario Values Only Accepted
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'description', 'city', 'street', 'house',  'room', 'housing', 'phone'], 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [['email', 'name', 'city', 'street', 'house', 'housing', 'room', 'phone'], 'string', 'max' => 255],
            [['description'], 'string'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'filter' => ['<>', 'id', $this->_user->id], 'message' => 'Этот email уже занят.'],
            [['password'], 'required', 'on' => self::SCENARIO_CREATE],
            ['password', 'string', 'min' => 5],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Пароли не совпадают."],
            [['phone'], 'match', 'pattern' => '/^\+7-[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}$/', 'message' => 'Неверный формат сотового телефона'],
            [['is_client', 'is_master', 'is_subscribe'], 'integer'],
        ];
    }

    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function create() {
        if (!$this->validate()) {
            return null;
        }
        $this->_user->email = $this->email;
        $this->_user->setPassword($this->password);
        $this->_user->generateAuthKey();
        $this->_user->status = 10;
        $this->_user->is_client = $this->is_client;
        $this->_user->is_master = $this->is_master;
        $this->_user->is_subscribe = $this->is_subscribe;
        return $this->_user->save() ? $this->_user : null;
    }


    /**
     * @return User|null
     * @throws \yii\base\Exception
     */
    public function update()
    {
        if (!$this->validate()) {
            return null;
        }
        $this->_user->email = $this->email;
        if ($this->password) {
            $this->_user->setPassword($this->password);
        }
        $this->_user->is_client = $this->is_client;
        $this->_user->is_master = $this->is_master;
        $this->_user->is_subscribe = $this->is_subscribe;

        $this->_user->info->name = $this->name;
        $this->_user->info->description = $this->description;
        $this->_user->info->city = $this->city;
        $this->_user->info->street = $this->street;
        $this->_user->info->house = $this->house;
        $this->_user->info->housing = $this->housing;
        $this->_user->info->phone = $this->phone;
        return ($this->_user->info->save() && $this->_user->save()) ? $this->_user : null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'E-Mail',
            'password' => 'Пароль',
            'password_repeat' => 'Подтвердите пароль',
            'is_client' => 'Клиент',
            'is_master' => 'Мастер',
            'is_subscribe' => 'Подписка',

            'name' => 'Имя и фамилия',
            'description' => 'Описание',
            'city' => 'Город',
            'phone' => 'Номер телефона',
            'street' => 'Улица',
            'house' => 'Дом',
            'room' => 'Квартира',
            'housing' => 'Корпус',
        ];
    }
}
