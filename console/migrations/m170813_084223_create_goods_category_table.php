<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_category`.
 */
class m170813_084223_create_goods_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('goods_category', [
            'id' => $this->primaryKey(),
            //tree	int()	树id
            'tree'=>$this->integer(22)->notNull()->comment('树id'),
            //lft	int()	左值
            'lft'=>$this->integer(20)->notNull()->comment('左值'),
            //rgt	int()	右值
            'rgt'=>$this->integer(20)->notNull()->comment('右值'),
            //depth	int()	层级
            'depth'=>$this->integer(20)->notNull()->comment('层级'),
            //name	varchar(50)	名称
            'name'=>$this->string('30')->notNull()->comment('名称'),
            //parent_id	int()	上级分类id
            'parent_id'=>$this->integer()->notNull()->comment('父id'),
            //intro	text()	简介
            'intro'=>$this->text()->notNull()->comment('商品分类简介'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_category');
    }
}
