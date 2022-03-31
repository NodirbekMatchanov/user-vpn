<?php

use yii\db\Migration;

/**
 * Class m220321_022538_add_new_column_vpns_to_table_user
 */
class m220321_022538_add_new_column_vpns_to_table_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->addColumn('user', 'vpnlogin', $this->string(255));
//        $this->addColumn('user', 'vpnpassword', $this->string(255));
//        $this->addColumn('user', 'until', $this->dateTime());
//        $this->addColumn('user', 'datecreate', $this->dateTime());
//        $this->addColumn('user', 'status', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m220321_022538_add_new_column_vpns_to_table_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220321_022538_add_new_column_vpns_to_table_user cannot be reverted.\n";

        return false;
    }
    */
}
