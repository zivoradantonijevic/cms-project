<?php

use yii\db\Migration;

class m161102_125012_banner_module extends Migration
{
    public function up()
    {
        $this->execute("
CREATE TABLE {{%banner_group}} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB ");
        $this->execute("CREATE TABLE {{%banner}} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `code` longtext,
  `image` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `end_time` datetime DEFAULT NULL,
  `sortorder` int(11) DEFAULT '0',
  `impressions` int(11) DEFAULT NULL,
  `clicks` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `group_id` (`group_id`),
  KEY `author` (`author`),
  CONSTRAINT  FOREIGN KEY (`group_id`) REFERENCES {{%banner_group}} (`id`),
  CONSTRAINT  FOREIGN KEY (`author`) REFERENCES {{%user}} (`id`)
) ENGINE=InnoDB 
");

    }

    public function down()
    {
        echo "m161102_125012_banner_module cannot be reverted.\n";

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
