<?php
namespace frontend\models;

use common\models\setting\Base;
use common\models\setting\Mail;
use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $email;
    public $password;
    public $repassword;
    public $is_subscribe;
    public $is_client;
    public $is_master;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_subscribe', 'is_client', 'is_master'], 'integer'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Такой E-mail уже зарегистрирован.'],

            [['password', 'repassword'], 'required'],
            ['password', 'string', 'min' => 6],
            ['repassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Пароли не совпадают."],
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль',
            'repassword' => 'Повторите пароль',
            'is_subscribe' => 'Получать Email-уведомления',
            'is_client' => 'Клиент',
            'is_master' => 'Мастер',
        ];
    }

    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->email = $this->email;
        $user->is_subscribe = $this->is_subscribe;
        $user->is_client = $this->is_client;
        $user->is_master = $this->is_master;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
//        print $this->sendEmail($user);
//        die;
        return $user->save() && $this->sendEmail($user);

    }

    protected function sendEmail($user)
    {
        $supportEmail = Mail::instance()->login;
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([($supportEmail ? $supportEmail : Yii::$app->params['supportEmail']) => Base::instance()->title])
            ->setTo($this->email)
            ->setSubject('Регистрация на сайте | ' . Base::instance()->title)
            ->send();
    }
}
