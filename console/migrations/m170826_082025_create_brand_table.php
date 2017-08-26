<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170826_082025_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('brand', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(100)->notNull()->comment('人'),
            'intro'=>$this->text()->notNull()->comment('jianjie'),
            'logo'=>$this->string(250)->notNull()->comment('图片'),
            'sort'=>$this->smallInteger(3)->notNull()->comment('收货人'),
            'status'=>$this->smallInteger(3)->notNull()->comment('ZHAUNGTAI'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('brand');
    }
}
