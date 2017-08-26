<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/20
 * Time: 20:42
 */

namespace backend\models;


use yii\base\Model;

class EditPermission extends Model
{
    public $name;
    public $description;
    public function rules()
    {
        return [
            [['name','description'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'权限名称',
            'description'=>'描述'
        ];
}

}