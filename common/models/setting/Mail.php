<?php

namespace common\models\setting;

use common\models\swp\search\Group;
use yii\base\Model;

/**
 * @property int $protocol
 * @property string $host
 * @property string $login
 * @property string $password
 * @property int $port
 * @property string $encryption
 */
class Mail extends Model
{
    public $protocol;
    public $host;
    public $login;
    public $password;
    public $port;
    public $encryption;

    public function init()
    {
        $material = Group::findOne(4)->material;
        $this->protocol = $material->getValue(10);
        $this->host = $material->getValue(11);;
        $this->login = $material->getValue(12);;
        $this->password = $material->getValue(13);;
        $this->port = $material->getValue(14);;
        $this->encryption = $material->getValue(15);;
        parent::init(); // TODO: Change the autogenerated stub
    }
}
