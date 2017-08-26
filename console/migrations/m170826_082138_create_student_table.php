<?php

use yii\db\Migration;

/**
 * Handles the creation of table `student`.
 */
class m170826_082138_create_student_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('student', [
            'student_id' => $this->primaryKey(),
            'name'=>$this->string(100)->notNull()->comment('人'),
            'sex'=>$this->string(100)->notNull()->comment('性别'),
            'class_id'=>$this->integer()->notNull()->comment('id'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('student');
    }
}
