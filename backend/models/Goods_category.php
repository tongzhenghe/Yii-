<?php
/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/13
 * Time: 16:56
 */

namespace backend\models;

use creocoder\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class Goods_category extends ActiveRecord
{
    //无限级分类插件
    public function behaviors() {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                 'treeAttribute' => 'tree',
//                 'leftAttribute' => 'lft',
//                 'rightAttribute' => 'rgt',
//                 'depthAttribute' => 'depth',

            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
    public static function find()
    {
        return new Goods_categoryQuery(get_called_class());
    }
    public function rules()
    {
        return [
            [['name','intro','parent_id'],'required'],
            [['tree', 'lft', 'rgt', 'depth', 'parent_id'], 'integer']
        ]; // TODO: Change the autogenerated stub
    }
    public function attributeLabels()
    {
        return [
            'name'=>'分类名称',
            'parent_id'=>'属于类',
            'intro'=>'商品分类简介'
        ]; // TODO: Change the autogenerated stub
    }
    //下拉排序显示到添加列表
    public static function getGoodsCategory(){
        return Json::encode(
            ArrayHelper::merge(
                [['id'=>0,'parent_id'=>0,'name'=>'顶级分类']],
                self::find()->all()
            )
        );
    }
    public function getTest(){
        return ArrayHelper::map(Goods_category::find()->all(),'id','name');
    }
    //建立对象之间的关系
    public function getChildrens(){
        return $this->hasMany(self::className(),['parent_id'=>'id']);
    }
}