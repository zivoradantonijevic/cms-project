<?php

use yii\db\Schema;

/**
 * Class m000000_000008_taxonomy.
 * Migration class for taxonomy.
 *
 * @author Agiel K. Saputra <13nightevil@gmail.com>
 * @since 0.1.0
 */
class m000000_000008_taxonomy extends \yii\db\Migration
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

        $this->createTable('{{%taxonomy}}', [
            'id' => Schema::TYPE_PK,
            'name' => Schema::TYPE_STRING . '(200) NOT NULL',
            'slug' => Schema::TYPE_STRING . '(200) NOT NULL',
            'hierarchical' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
            'singular_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'plural_name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'menu_builder' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0',
        ], $tableOptions);

        /**
         * Add two taxonomies, that are category and tag
         */
        $this->batchInsert(
            '{{%taxonomy}}',
            ['name', 'slug', 'hierarchical', 'singular_name', 'plural_name', 'menu_builder'], [
                ['category', 'category', '1', 'Category', 'Categories', 1],
                ['tag', 'tag', '0', 'Tag', 'Tags', 0],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%taxonomy}}');
    }
}
