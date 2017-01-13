<?php

use yii\db\Migration;

class m161103_102902_sliders extends Migration
{
    public function up()
    {
$this->execute("CREATE TABLE {{%slider_group}} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB");

        $this->execute("CREATE TABLE {{%slider}} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `code` longtext,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `sortorder` int(11) DEFAULT NULL,
  `is_published` tinyint(4) DEFAULT NULL,
  `title_en` varchar(255) CHARACTER SET utf8 NOT NULL,
  `title_tr` varchar(255) CHARACTER SET utf8 NOT NULL,
  `subtitle_en` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `subtitle_tr` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `author` (`author`),
  CONSTRAINT  FOREIGN KEY (`group_id`) REFERENCES {{%slider_group}} (`id`),
  CONSTRAINT  FOREIGN KEY (`author`) REFERENCES {{%user}} (`id`)
) ENGINE=InnoDB");
    }

    public function down()
    {
        echo "m161103_102902_sliders cannot be reverted.\n";

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
