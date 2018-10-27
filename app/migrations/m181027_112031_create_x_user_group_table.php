<?php

use yii\db\Migration;

/**
 * Handles the creation of table `x_user_group`.
 */
class m181027_112031_create_x_user_group_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('x_user_group', [
            'id' => 'INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'group_id' => 'INT(11) NOT NULL',
            'user_id' => 'INT(11) NOT NULL',
            'crdate' => 'INT(11) DEFAULT 0',
            'tstamp' => 'INT(11) DEFAULT 0',
        ]);
        $this->addForeignKey('x_group_relation','x_user_group','group_id','groups','id');
        $this->addForeignKey('x_user_relation','x_user_group','user_id','users','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('x_user_group');
    }
}
