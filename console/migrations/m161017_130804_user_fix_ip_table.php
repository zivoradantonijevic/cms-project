<?php

use yii\db\Migration;
use yii\db\Schema;

class m161017_130804_user_fix_ip_table extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_BIGINT);
    }

    public function down()
    {
        $this->alterColumn('{{%user}}', 'registration_ip', Schema::TYPE_INTEGER);
    }
}
