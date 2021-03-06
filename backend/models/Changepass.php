<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/17
 * Time: 20:15
 */

namespace backend\models;


use yii\base\Model;

class Changepass extends Model
{
    public $repassword;
    public $password;
    public $newpassword;
    public function rules()
    {
        return[
            [['newpassword'], 'string'],
            [['password'], 'string'],
            [['repassword'], 'string'],
            [['newpassword','repassword','password'],'required'],
            ['repassword', 'compare', 'compareAttribute' => 'newpassword', 'message' => '两次密码输入不一致'],
        ]; // TODO: Change the autogenerated stubsd
    }
    public function attributeLabels()
    {
        return[
            'repassword' =>'确认密码',
            'newpassword' =>'新密码',
            'password' =>'旧密码',
        ]; // TODO: Change the autogenerated stub
    }

}