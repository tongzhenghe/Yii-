<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/11
 * Time: 16:18
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Student extends ActiveRecord
{
public function rules()
{
    return [
    [['name','age','sex','class_id'],'required']
    ]; // TODO: Change the autogenerated stub
    }
    public function attributeLabels()
    {
        return [
            'name'=>'学生姓名',
            'sex'=>'学生性别',
            'age'=>'学生年龄',
            'class_id'=>'学生编号'


        ]; // TODO: Change the autogenerated stub
    }
}