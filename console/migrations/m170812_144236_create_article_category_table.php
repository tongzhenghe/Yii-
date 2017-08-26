<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_category`.
 */
class m170812_144236_create_article_category_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article_category', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('分类名称'),
            'intro'=>$this->text()->notNull()->comment('分类简介'),
            'sort'=>$this->integer(59)->notNull()->comment('分类排序'),
            'status'=>$this->smallInteger(3)->notNull()->comment('分类排序')
        ]);
    }
    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_category');
    }
}
