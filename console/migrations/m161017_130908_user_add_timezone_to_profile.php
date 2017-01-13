<?php

use yii\db\Schema;
use yii\db\Migration;

class m161017_130908_user_add_timezone_to_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%profile}}', 'timezone', Schema::TYPE_STRING . '(40)');
    }

    public function down()
    {
        $this->dropcolumn('{{%profile}}', 'timezone');
    }

}
