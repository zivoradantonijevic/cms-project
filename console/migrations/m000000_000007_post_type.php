<?php

use yii\db\Schema;

/**
 * Class m000000_000007_post_type.
 * Migration class for post_type.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class m000000_000007_post_type extends \yii\db\Migration
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

        $this->createTable('{{%post_type}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'slug' => Schema::TYPE_STRING . '(64) NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'icon' => Schema::TYPE_STRING . '(255)',
            'singular_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'plural_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'menu_builder' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'permission' => Schema::TYPE_STRING . '(64) NOT NULL',
        ], $tableOptions);

        /**
         * Initialize post type with "post" and "page"
         */
        $this->batchInsert(
            '{{%post_type}}',
            ['id', 'name', 'slug', 'icon', 'singular_name', 'plural_name', 'menu_builder', 'permission'], [
                ['1', 'post', 'post', 'fa fa-thumb-tack', 'Post', 'Posts', 0, 'contributor'],
                ['2', 'page', 'page', 'fa fa-file-o', 'Page', 'Pages', 1, 'editor'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%post_type}}');
    }
}
