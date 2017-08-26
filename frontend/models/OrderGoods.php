<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order_goods".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $goods_id
 * @property integer $goods_name
 * @property string $logo
 * @property string $price_decimal
 * @property integer $amount
 * @property string $total
 */
class OrderGoods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_goods';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'goods_id', 'goods_name', 'logo', 'price_decimal', 'amount', 'total'], 'required'],
            [['order_id', 'goods_id', 'goods_name', 'amount'], 'integer'],
            [['price_decimal', 'total'], 'number'],
            [['logo'], 'string', 'max' => 288],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => '订单id',
            'goods_id' => '商品id',
            'goods_name' => '商品名称',
            'logo' => '图片',
            'price_decimal' => '价格',
            'amount' => '数量',
            'total' => '小计',
        ];
    }
}
