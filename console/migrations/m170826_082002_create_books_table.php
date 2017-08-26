<?php

use yii\db\Migration;

/**
 * Handles the creation of table `books`.
 */
class m170826_082002_create_books_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('books', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(30)->notNull()->comment('标题'),
            'intro'=>$this->text()->notNull()->comment('树'),
            'logo'=>$this->string(255)->notNull()->comment('图片'),
            'addTime'=>$this->string(100)->notNull()->comment('jisan'),
            'student_id'=>$this->integer()->notNull()->comment('id'),
            'author'=>$this->string(100)->notNull()->comment('作者'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('books');
    }
}
