<?php

use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 */
class m181026_190526_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name' => 'VARCHAR(255) NOT NULL UNIQUE',
            'crdate' => 'INT(11) DEFAULT 0',
            'tstamp' => 'INT(11) DEFAULT 0',
            'deleted' => 'TINYINT(1) DEFAULT 0',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }
}
