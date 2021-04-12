<?php
namespace frontend\widgets\models;


use common\models\User;
use yii\base\Model;

class PhotoForm extends Model
{
    public $file;
    public $photo_points;

    /**
     * @var $user User
     */
    public $user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'jpg, png, gif'],
            [['photo_points'], 'string'],
        ];
    }

    public function __construct($user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }
}
