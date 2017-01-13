<?php

use yii\db\Migration;

class m161103_082324_banner_is_published extends Migration
{
    public function up()
    {
        $this->execute("ALTER TABLE {{%banner}}
ADD `is_published` tinyint NULL;");

    }

    public function down()
    {
        echo "m161103_082324_banner_is_published cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
