<?php

use yii\db\Migration;

/**
 * Handles the creation of table `classs`.
 */
class m170826_082057_create_classs_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('classs', [
            'class_id' => $this->primaryKey(),
            'class_name'=>$this->string(100)->notNull()->comment('人'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('classs');
    }
}
