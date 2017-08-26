<?php
namespace backend\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class Goods_categoryQuery extends \yii\db\ActiveQuery
{
    public function behaviors() {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}