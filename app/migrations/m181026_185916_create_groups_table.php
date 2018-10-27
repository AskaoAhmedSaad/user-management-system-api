<?php

use yii\db\Migration;

/**
 * Handles the creation of table `groups`.
 */
class m181026_185916_create_groups_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('groups', [
            'id' => 'INT(5) NOT NULL AUTO_INCREMENT PRIMARY KEY',
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
        $this->dropTable('groups');
    }
}
