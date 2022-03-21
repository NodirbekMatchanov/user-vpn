<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%vpn_user_settings}}`.
 */
class m220320_181905_create_vpn_user_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%vpn_user_settings}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'vpnlogin' => $this->string(255),
            'vpnpassword' => $this->string(255),
            'until' => $this->datetime(),
            'status' => $this->string(50),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%vpn_user_settings}}');
    }
}
