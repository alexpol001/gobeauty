<?php

namespace frontend\models;

use common\models\setting\Base;
use common\models\setting\Mail;
use Yii;
use yii\base\Model;

/*
 *
 */
class ContactForm extends Model
{
    public $body;
    public $user;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['body'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'body' => 'Тело сообщение',
        ];
    }

    public function sendEmail()
    {
        $supportEmail = Mail::instance()->login;
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'support/html', 'text' => 'support/text'],
                ['model' => $this]
            )
            ->setFrom([($supportEmail ? $supportEmail : Yii::$app->params['supportEmail']) => Base::instance()->title])
            ->setTo($supportEmail)
            ->setSubject('Запрос с сайта (Поддержка) | ' . Base::instance()->title)
            ->send();
    }
}
