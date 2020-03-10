<?php

namespace app\models;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_NOTCONFIRMED = 10;
    const STATUS_ACTIVE = 20;
    
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_NOTCONFIRMED],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_NOTCONFIRMED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
     public static function findIdentityByAccessToken($token, $type = null)
     {
         throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
     }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getStatus()
    {
        if ($this->status == self::STATUS_ACTIVE) return "Confirmed";
        else return "Not confirmed";
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
     */
     public function setPassword($password)
     {
         $this->password_hash = Yii::$app->security->generatePasswordHash($password);
     }
  
     /**
      * Generates "remember me" authentication key
      */
     public function generateAuthKey()
     {
         $this->auth_key = Yii::$app->security->generateRandomString();
     }
}
