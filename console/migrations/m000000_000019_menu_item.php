<?php

use yii\db\Schema;

/**
 * Class m000000_000019_menu_item
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class m000000_000019_menu_item extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%menu_item}}', [
            'id' => Schema::TYPE_PK,
            'menu_id' => Schema::TYPE_INTEGER . '(11) NOT NULL',
            'label' => Schema::TYPE_STRING . '(255) NOT NULL',
            'url' => Schema::TYPE_TEXT . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'order' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
            'parent' => Schema::TYPE_INTEGER . '(11) NOT NULL DEFAULT 0',
            'options' => Schema::TYPE_TEXT,
            'FOREIGN KEY ([[menu_id]]) REFERENCES {{%menu}} ([[id]]) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu_item}}');
    }
}
