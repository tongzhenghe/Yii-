<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m170824_081708_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     */

    public function up()
    {
        $this->createTable('cart', [
            //字段名	类型	注释
            'id' => $this->primaryKey(),
            //goods_id	int	商品id
            'goods_id'=>$this->integer()->notNull()->comment('商品id'),
            //amount	int	商品数量
            'amount'=>$this->integer()->notNull()->comment('商品数量'),
            //member_id	int	用户id
            'member_id'=>$this->integer()->notNull()->comment('用户id'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
