<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m170814_041819_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            // name	varchar(20)	商品名称
            'name'=>$this->string(30)->notNull()->comment('商品名称'),
            //sn	varchar(20)	货号
            'sn'=>$this->string(20)->notNull()->comment('货号'),
            //logo	varchar(255)	LOGO图片
            'logo'=>$this->string(266)->notNull()->comment('LOGO图片'),
            //goods_category_id	int	商品分类id
            'goods_category_id'=>$this->integer()->notNull()->comment('商品分类id'),
            //brand_id	int	品牌分类
            'brand_id'=>$this->integer()->notNull()->comment('品牌分类'),
            //market_price	decimal(10,2)	市场价格
            'market_price'=>$this->decimal(10,2)->notNull()->comment('市场价格'),
            //shop_price	decimal(10, 2)	商品价格
            'shop_price'=>$this->decimal(10, 2)->notNull()->comment('商品价格'),
            //stock	int	库存
            'stock'=>$this->integer(33)->notNull()->comment('库存'),
            //is_on_sale	int(1)	是否在售(1在售 0下架)
            'is_on_sale'=>$this->smallInteger(3)->notNull()->comment('是否在售(1在售 0下架'),
            //status	inter(1)	状态(1正常 0回收站)
            'status'=>$this->smallInteger(2)->notNull()->comment('状态(1正常 0回收站)'),
            //sort	int()	排序
            'sort'=>$this->integer()->notNull()->comment('排序'),
            //create_time	int()	添加时间
            'create_time'=>$this->integer()->notNull()->comment('添加时间'),
            //view_times	int()	浏览次数
            'view_times'=>$this->integer()->notNull()->comment('浏览次数')
        ]);
    }
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
