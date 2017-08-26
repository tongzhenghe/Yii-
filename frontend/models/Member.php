<?php

namespace frontend\models;

use Symfony\Component\Console\Input\InputAwareInterface;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $email
 * @property string $tel
 * @property integer $last_login_time
 * @property integer $last_login_ip
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public $repassword;
    public $password;
    public $checkcode;
    public function rules()
    {
        return [
            [['username', 'password','repassword','checkcode', 'email', 'tel'], 'required'],
            [['last_login_time', 'last_login_ip', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 100],
            [['tel'], 'string', 'max' => 11],
            ['repassword', 'compare', 'compareAttribute' => 'password', 'message' => '两次密码输入不一致']
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'email' => 'Email',
            'tel' => 'Tel',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public static function findIdentity($id)//根据id查找当前用户
    {
        return self::findOne($id);
        // TODO: Implement findIdentity() method.
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    public function getId()//获取当前对象id
    {
        return $this->id;
        // TODO: Implement getId() method.
    }

    public function getAuthKey()//获取验证登录
    {
        //获取自动登陆事务AuthKey
        return $this->auth_key;
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)//验证自动登录
    {
        return $this->auth_key === $authKey;
        // TODO: Implement validateAuthKey() method.
    }

}
