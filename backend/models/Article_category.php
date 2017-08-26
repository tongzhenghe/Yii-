<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/12
 * Time: 22:54
 */

namespace backend\models;


use yii\db\ActiveRecord;

class Article_category extends ActiveRecord
{
    public function rules()
    {
        return [
            [['name','intro','sort','status'],'required']
        ]; // TODO: Change the autogenerated stub
    }
    public function attributeLabels()
    {
        return [
            'name'=>'分类名称',
            'intro'=>'分类简介',
            'sort'=>'分类排序',
            'status'=>'分类状态'
        ]; // TODO: Change the autogenerated stub
    }

}