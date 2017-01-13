<?php

use console\migrations\Migration;
use yii\db\Schema;

class m000000_000000_user_init extends Migration
{
    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . '(25) NOT NULL',
            'email' => Schema::TYPE_STRING . '(255) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . '(60) NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'confirmation_token' => Schema::TYPE_STRING . '(32)',
            'confirmation_sent_at' => Schema::TYPE_INTEGER,
            'confirmed_at' => Schema::TYPE_INTEGER,
            'unconfirmed_email' => Schema::TYPE_STRING . '(255)',
            'recovery_token' => Schema::TYPE_STRING . '(32)',
            'recovery_sent_at' => Schema::TYPE_INTEGER,
            'blocked_at' => Schema::TYPE_INTEGER,
            'registered_from' => Schema::TYPE_INTEGER,
            'logged_in_from' => Schema::TYPE_INTEGER,
            'logged_in_at' => Schema::TYPE_INTEGER,
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);

        $this->createIndex('user_unique_username', '{{%user}}', 'username', true);
        $this->createIndex('user_unique_email', '{{%user}}', 'email', true);
        $this->createIndex('user_confirmation', '{{%user}}', 'id, confirmation_token', true);
        $this->createIndex('user_recovery', '{{%user}}', 'id, recovery_token', true);

        $this->createTable('{{%profile}}', [
            'user_id' => Schema::TYPE_INTEGER . ' PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255)',
            'public_email' => Schema::TYPE_STRING . '(255)',
            'gravatar_email' => Schema::TYPE_STRING . '(255)',
            'gravatar_id' => Schema::TYPE_STRING . '(32)',
            'location' => Schema::TYPE_STRING . '(255)',
            'website' => Schema::TYPE_STRING . '(255)',
            'bio' => Schema::TYPE_TEXT,
        ], $this->tableOptions);

        $this->addForeignKey('fk_user_profile', '{{%profile}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');


        /**
         * Insert super administrator.
         * Initialize super administrator with user superadmin and password superadmin.
         * After installing this app success, change the username and password of superadmin immediately.
         */
        $this->insert('{{%user}}', [
            'id' => 1,
            'username' => 'superadmin',
            'email' => 'superadministrator@writesdown.com',
            /*            'full_name' => 'Super Administrator',
                        'display_name' => 'Super Admin',*/
            'password_hash' => '$2y$13$WJIxqq6WBZUw7tyfN2oiH.WJtPntvLMjs6NG9uW0M3Lh71lImaEyu',
            // 'password_reset_token' => null,
            'auth_key' => '7QvEmdZDvaSxM1-oYoWkKso0ws6AHTX1',
            //'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%profile}}', [
            'user_id' => 1,
            'name' => 'Super Administrator',
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%profile}}');
        $this->dropTable('{{%user}}');
    }
}
