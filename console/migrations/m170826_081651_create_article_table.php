<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m170826_081651_create_article_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(100)->notNull()->comment('文章名称'),
            'intro'=>$this->text()->notNull()->comment('简介'),
            'status'=>$this->smallInteger(2)->notNull()->comment('状态'),
            'sort'=>$this->integer()->notNull()->comment('排序'),
            'photo'=>$this->string(255)->notNull()->comment('图片'),
            'article_category_id'=>$this->integer()->notNull()->comment('di'),
            'create_time'=>$this->integer()->notNull()->comment('创建时间'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
