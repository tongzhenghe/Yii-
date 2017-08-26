<?php

use yii\db\Migration;

/**
 * Handles the creation of table `menu`.
 */
class m170820_030750_create_menu_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('menu', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(40)->notNull()->comment('菜单名称'),
            'parent_id'=>$this->integer()->notNull()->comment('父id'),
            'sort'=>$this->integer()->notNull()->comment('排序')
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('menu');
    }
}
