<?php

namespace common\models;

use common\components\Common;
use common\models\swp\Material;
use frontend\components\Frontend;
use kartik\widgets\FileInput;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $verification_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property integer $is_subscribe
 * @property integer $is_client
 * @property integer $is_master
 * @property UserInfo $info
 * @property MasterOrders[] $mOrders
 * @property Review[] $reviews
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_INACTIVE = 9;
    const STATUS_ACTIVE = 10;
    const STATUS_ADMIN = 100;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_INACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ADMIN, self::STATUS_ACTIVE, self::STATUS_INACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE, self::STATUS_ADMIN]]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByUserEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => [self::STATUS_ACTIVE, self::STATUS_ADMIN]]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => [self::STATUS_ACTIVE, self::STATUS_ADMIN],
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token)
    {
        return static::findOne([
            'verification_token' => $token,
            'status' => self::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'E-mail',
            'is_client' => 'Клиент',
            'is_master' => 'Мастер',
            'is_subscribe' => 'Подписка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterials()
    {
        return $this->hasMany(Material::className(), ['group_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
    }

    public function getMOrders()
    {
        return $this->hasMany(MasterOrders::className(), ['user_id' => 'id']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInfo()
    {
        if (!UserInfo::findOne(['user_id' => $this->id])) {
            $info = new UserInfo();
            $info->user_id = $this->id;
            $info->save();
        }
        return $this->hasOne(UserInfo::className(), ['user_id' => 'id']);
    }

    /**
     * @param null $slug
     * @return Orders[]
     */
    public function getClientOrders($slug = null)
    {
        if ($slug) {
            if ($category = Material::findOne(['group_id' => Orders::CATEGORY_GROUP, 'slug' => $slug])) {
                return array_reverse(Orders::findAll(['client_id' => $this->id, 'category_id' => $category->id]));
            }
        }
        return array_reverse(Orders::findAll(['client_id' => $this->id]));
    }

    /**
     * @param null $slug
     * @return Orders[]
     */
    public function getMasterOrders($slug = null)
    {
        $orders = Orders::find();
        if ($this->mOrders) {
            foreach ($this->mOrders as $order) {
                $orders->andWhere(['id' => $order->order_id]);
            }
        }
        $orders->orWhere(['master_id' => $this->id]);
        if ($slug) {
            if ($category = Material::findOne(['group_id' => Orders::CATEGORY_GROUP, 'slug' => $slug])) {
                $orders->andWhere(['category_id' => $category->id]);
            }
        }
        return array_reverse($orders->all());
    }

    public function getFreeOrders($slug = null)
    {
        if ($slug && $category = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $slug)) {
            $orders = Orders::find()->where(['category_id' => $category->id])
                ->andWhere(['is', 'master_id', null])
                ->andWhere(['<>', 'client_id', $this->id]);
        } else {
            $orders = Orders::find()->where(['is', 'master_id', null])
                ->andWhere(['<>', 'client_id', $this->id]);;
        }
        $orders = $orders->andWhere(['<>', 'status', 0]);
        $orders = $orders->andWhere(['>', 'date', time()]);
        foreach ($this->mOrders as $order) {
            $orders = $orders->andWhere(['<>', 'id', $order->order_id]);
        }
        return array_reverse($orders->all());
    }

    /**
     * @return bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function beforeDelete()
    {
        if ($this->isAdmin()) return false;
        Common::deleteAll($this->getClientOrders());
        Common::deleteAll($this->reviews);
        $this->info->delete();

        $path = Yii::getAlias("@frontend/web/uploads/users/".$this->id);
        if (file_exists($path)) {
            FileHelper::removeDirectory($path);
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

    public function becomeRole($is_master = false)
    {
        if (!$is_master) {
            $this->is_client = 1;
        } else {
            $this->is_master = 1;
        }
        return $this->save();
    }

    public function getGeoMasters($slug = null, $exclude = null)
    {
        $masters = self::find()
            ->where(['is_master' => 1])
            ->andWhere(['<>', 'id', $this->id]);
        if ($exclude) {
            $masters = $masters->andWhere(['not in', 'id', explode(',', $exclude)]);
        }
        $masters = $masters->all();
        if ($slug) {
            if (($category = Material::getMaterialBySlug(Orders::CATEGORY_GROUP, $slug)) && $masters) {
                /** @var User $master */
                foreach ($masters as $key => $master) {
                    if (!in_array($category->id, explode(', ', $master->info->categories))) {
                        unset($masters[$key]);
                    }
                }
                sort($masters);
            }
        }
        /** @var User[] $masters */
        $result = $masters;
        if (($n = count($masters)) > 3) {
            /** @var User[] $result */
            usort(
                $result, function ($a, $b) {
                /** @var User $a */
                /** @var User $b */
                $a = $a->getDistance($this);
                $b = $b->getDistance($this);
                if ($a) {
                    $a *= 10;
                } else {
                    return 1;
                }
                if ($b) {
                    $b *= 10;
                } else {
                    return -1;
                }
                return $a - $b;
            });
            $result = array_splice($result, 0, 3);
        } else {
            usort(
                $result, function ($a, $b) {
                /** @var User $a */
                /** @var User $b */
                $a = $a->getDistance($this);
                $b = $b->getDistance($this);
                if ($a) {
                    $a *= 10;
                } else {
                    return 1;
                }
                if ($b) {
                    $b *= 10;
                } else {
                    return -1;
                }
                return $a - $b;
            });
            $result['finish'] = true;
        }
        return $result;
    }

    /**
     * @param User $user
     * @return int|null
     */
    public function getDistance($user)
    {
        $distance = null;
        if (($point1 = $user->info->location) && ($point2 = $this->info->location)) {
            $point1 = explode(', ', $point1);
            $point2 = explode(', ', $point2);

            $distance = ceil(sqrt(pow($point2[0] - $point1[0], 2) + pow($point2[1] - $point1[1], 2)) * 1000) / 10;
        }
        return $distance;
    }

    /**
     * @param User $master
     * @return bool
     */
    public function allowReview($master)
    {
        $result = Review::findOne(['author_id' => $this->id, 'user_id' => $master->id]);
        if ($result) return false;
        if ($orders = $this->getClientOrders()) {
            foreach ($this->getClientOrders() as $order) {
                if ($order->date < time() && $order->master_id == $master->id) {
                    return true;
                }
            }
        }
        return false;
    }

    public function isAdmin() {
        return $this->status == self::STATUS_ADMIN;
    }

}
