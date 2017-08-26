<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_intro`.
 */
class m170814_041926_create_goods_intro_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_intro', [
            // goods_id	int	商品id
            'goods_id'=>$this->integer()->notNull()->comment('商品id'),
            //content	text	商品描述
            'content'=>$this->text()->notNull()->comment('商品描述')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_intro');
    }
}
