<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%accs}}`.
 */
class m220328_112124_create_accs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql =   "ALTER TABLE `accs` ADD `comment` TEXT NULL DEFAULT NULL AFTER `status`, ADD `test_user` INT(2) NULL DEFAULT NULL AFTER `comment`, ADD `role` VARCHAR(50) NULL DEFAULT NULL AFTER `test_user`, ADD `tariff` VARCHAR(50) NULL DEFAULT NULL AFTER `role`, ADD `promocode` VARCHAR(50) NULL DEFAULT NULL AFTER `tariff`;";
        $sql .=   "ALTER TABLE `accs` ADD `use_android` INT(2) NULL DEFAULT NULL AFTER `promocode`, ADD `use_ios` INT(2) NULL DEFAULT NULL AFTER `use_android`, ADD `token` TEXT NULL DEFAULT NULL AFTER `use_ios`, ADD `fcm token` TEXT NULL DEFAULT NULL AFTER `token`, ADD `last_date_visit` DATE NULL DEFAULT NULL AFTER `fcm token`,
    ADD `visit_count` INT NULL DEFAULT NULL AFTER `last_date_visit`;";
                \Yii::$app->db2->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
    }
}
