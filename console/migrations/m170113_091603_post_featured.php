<?php

use yii\db\Migration;

class m170113_091603_post_featured extends Migration
{
    public function up()
    {
$this->execute("ALTER TABLE {{post}}
ADD `featured` `featured` tinyint(4) NULL DEFAULT '0' AFTER `comment_count`,
ADD `views_count` int(10) unsigned NULL DEFAULT '0',
ADD `thumbnail` varchar(255) NULL
;");
    }

    public function down()
    {
        echo "m170113_091603_post_featured cannot be reverted.\n";

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
