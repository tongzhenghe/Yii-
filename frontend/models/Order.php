<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $member_id
 * @property string $name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $tel
 * @property integer $delivery_id
 * @property string $delivery_name
 * @property double $delivery_price
 * @property integer $payment_id
 * @property string $payment_name
 * @property string $total
 * @property integer $status
 * @property string $trade_no
 * @property integer $create_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public static $deliveries = [
        1=>['顺丰快递',20,'价格贵，速度快，服务好'],
        2=>['EMS',15,'价格贵，速度一般，服务一般'],
        ];
    public static $orders = [
        1=>['微信支付宝'],
    ];
    public static $staus = [//订单状态（0已取消1待付款2待发货3待收货4完成）
        1=>['已取消'],
        2=>['待付款'],
        3=>['待发货'],
        4=>['待收货'],
        ];
    public function rules()
    {
        return [
            [['name', 'province','member_id', 'city', 'area', 'address', 'tel', 'delivery_id', 'payment_id', 'total', 'create_time'], 'required'],
            [['delivery_name', 'payment_name',],'safe'],
            [['member_id', 'delivery_id', 'payment_id', 'status', 'create_time'], 'integer'],
            [['delivery_price', 'total'], 'number'],
            [['name', 'province', 'city', 'area', 'address', 'payment_name', 'trade_no'], 'string', 'max' => 30],
            [['tel'], 'string', 'max' => 122],
            [['delivery_name'], 'string', 'max' => 111],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_id' => 'Member ID',
            'name' => 'Name',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'tel' => 'Tel',
            'delivery_id' => 'Delivery ID',
            'delivery_name' => 'Delivery Name',
            'delivery_price' => 'Delivery Price',
            'payment_id' => 'Payment ID',
            'payment_name' => 'Payment Name',
            'total' => 'Total',
            'status' => 'Status',
            'trade_no' => 'Trade No',
            'create_time' => 'Create Time',
        ];
    }
}
