<?php

use yii\db\Schema;

/**
 * Class m000000_000018_menu
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class m000000_000018_menu extends \yii\db\Migration
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

        $this->createTable('{{%menu}}', [
            'id' => Schema::TYPE_PK,
            'title' => Schema::TYPE_STRING . '(255) NOT NULL',
            'location' => Schema::TYPE_STRING . '(50)',
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%menu}}');
    }
}
