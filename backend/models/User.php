<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/16
 * Time: 17:29
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{

    public static function findIdentity($id)//根据id查找当前用户
    {
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
        return $this->AuthKey;
        // TODO: Implement getAuthKey() method.
    }

    public function validateAuthKey($authKey)//验证自动登录
    {
        return $this->$authKey === $this->AuthKey();
        // TODO: Implement validateAuthKey() method.
    }

}