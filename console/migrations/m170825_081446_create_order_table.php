<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m170825_081446_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            //字段名	类型	注释
            //member_id	int	用户id
            'member_id'=>$this->integer()->notNull()->comment('	用户id'),
            //name	varchar(50)	收货人
            'name'=>$this->string(30)->notNull()->comment('收货人'),
            //province	varchar(20)	省
            'province'=>$this->string(30)->notNull()->comment('省'),
            //city	varchar(20)	市
            'city'=>$this->string(30)->notNull()->comment('市'),
            //area	varchar(20)	县
            'area'=>$this->string(30)->notNull()->comment('县'),
            //address	varchar(255)	详细地址
            'address'=>$this->string(30)->notNull()->comment('收货人'),
            //tel	char(11)	电话号码
            'tel'=>$this->string(122)->notNull()->comment('详细地址'),
            //delivery_id	int	配送方式id
            'delivery_id'=>$this->integer()->notNull()->comment('配送方式id'),
            //delivery_name	varchar	配送方式名称
            'delivery_name'=>$this->string(111)->notNull()->comment('	配送方式名称'),
            //delivery_price	float	配送方式价格
            'delivery_price'=>$this->float()->notNull()->comment('配送方式价格'),
            //payment_id	int	支付方式id
            'payment_id'=>$this->integer()->notNull()->comment('支付方式id'),
            //payment_name	varchar	支付方式名称
            'payment_name'=>$this->string(30)->notNull()->comment('支付方式名称'),
            //total_decimal	订单金额
            'total_decimal'=>$this->string(30)->notNull()->comment('订单金额'),
            //status	int	订单状态（0已取消1待付款2待发货3待收货4完成）
            'status'=>$this->smallInteger(2)->notNull()->comment('订单状态（0已取消1待付款2待发货3待收货4完成）'),
            //trade_no	varchar	第三方支付交易号
            'trade_no'=>$this->string(30)->notNull()->comment('第三方支付交易号'),
            //create_time	int	创建时间
            'create_time'=>$this->integer()->notNull()->comment('	创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
