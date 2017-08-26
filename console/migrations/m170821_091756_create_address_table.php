<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m170821_091756_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'consignee'=>$this->string(100)->notNull()->comment('收货人'),
            'town'=>$this->string(100)->notNull()->comment('市'),
            'district'=>$this->string(100)->notNull()->comment('区'),
            'place'=>$this->string(100)->notNull()->comment('地方'),
            'detailedAddress'=>$this->string(100)->notNull()->comment('详细地址'),
            'tel'=>$this->char(11)->notNull()->comment('手机号码'),
            'status'=>$this->smallInteger(2)->notNull()->comment('状态（1正常，0删除）'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
