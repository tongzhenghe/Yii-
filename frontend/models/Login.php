<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/21
 * Time: 15:22
 */

namespace frontend\models;


use yii\base\Model;

class Login extends Model
{
    public $username;
    public $password;
    public $member;
//    public $checkcode;
    public function rules()
    {
        return [
            [['username','password'],'required'],
//            ['checkcode','captcha','captchaAction' => 'site/captcha'],
//            ['rememberMe','safe']//这个字段是安全的，不需要验证
        ];
    }
}