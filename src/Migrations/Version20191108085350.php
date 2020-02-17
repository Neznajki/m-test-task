<?php /** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection SqlResolve */
/** @noinspection SqlNoDataSourceInspection */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191108085350 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');
        $this->addSql('CREATE TABLE rel_collection (id INT UNSIGNED AUTO_INCREMENT NOT NULL, rel_name VARCHAR(128) CHARACTER SET latin1 NOT NULL COLLATE `latin1_bin`, UNIQUE INDEX u_rel_name (rel_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_collection (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type_name VARCHAR(128) CHARACTER SET latin1 NOT NULL COLLATE `latin1_general_ci`, UNIQUE INDEX u_type_name (type_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE most_common_words (id INT UNSIGNED AUTO_INCREMENT NOT NULL, word VARCHAR(16) CHARACTER SET latin1 NOT NULL COLLATE `latin1_general_ci`, oec_rank TINYINT(3) UNSIGNED NOT NULL, coca_rank TINYINT(3) UNSIGNED DEFAULT NULL, UNIQUE INDEX u_word (word), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE word (id INT UNSIGNED AUTO_INCREMENT NOT NULL, word VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, UNIQUE INDEX u_word (word), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feed_author (id INT UNSIGNED AUTO_INCREMENT NOT NULL, full_name VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, homepage_uri VARCHAR(128) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email_address VARCHAR(128) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, created DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE external_id (id INT UNSIGNED AUTO_INCREMENT NOT NULL, author_id INT UNSIGNED NOT NULL, external_id VARCHAR(128) CHARACTER SET utf8 NOT NULL COLLATE `utf8_bin`, last_update_time DATETIME NOT NULL, last_import_time DATETIME NOT NULL, imported DATETIME NOT NULL, is_removed TINYINT(1) NOT NULL, is_handling TINYINT(1) NOT NULL, UNIQUE INDEX u_external_id (external_id), INDEX author_id (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feed_link (id INT UNSIGNED AUTO_INCREMENT NOT NULL, external_id INT UNSIGNED NOT NULL, rel_id INT UNSIGNED NOT NULL, type_id INT UNSIGNED NOT NULL, href VARCHAR(200) CHARACTER SET latin1 NOT NULL COLLATE `latin1_bin`, imported DATETIME NOT NULL, UNIQUE INDEX u_external_id_href (external_id, href), INDEX rel_id (rel_id), INDEX type_id (type_id), INDEX IDX_B63B72A69F75D7B0 (external_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feed_summary (id INT UNSIGNED AUTO_INCREMENT NOT NULL, external_id INT UNSIGNED NOT NULL, type_id INT UNSIGNED NOT NULL, content TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, UNIQUE INDEX u_external_id (external_id), INDEX type_id (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE feed_title (id INT UNSIGNED AUTO_INCREMENT NOT NULL, external_id INT UNSIGNED NOT NULL, type_id INT UNSIGNED NOT NULL, content TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, imported DATETIME NOT NULL, UNIQUE INDEX u_external_id (external_id), INDEX type_id (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');

        //manual
        $this->addSql('INSERT INTO `most_common_words` (`word`, `oec_rank`, `coca_rank`) VALUES 
("the", 1, 1),
("be", 2, 2),
("to", 3, 7),
("of", 4, 4),
("and", 5, 3),
("a", 6, 5),
("in", 7, 6),
("that", 8, 12),
("have", 9, 8),
("I", 10, 11),
("it", 11, 10),
("for", 12, 13),
("not", 13, 28),
("on", 14, 17),
("with", 15, 16),
("he", 16, 15),
("as", 17, 33),
("you", 18, 14),
("do", 19, 18),
("at", 20, 22),
("this", 21, 20),
("but", 22, 23),
("his", 23, 25),
("by", 24, 30),
("from", 25, 26),
("they", 26, 21),
("we", 27, 24),
("say", 28, 19),
("her", 29, 42),
("she", 30, 31),
("or", 31, 32),
("an", 32, null),
("will", 33, 48),
("my", 34, 44),
("one", 35, 51),
("all", 36, 43),
("would", 37, 41),
("there", 38, 53),
("their", 39, 36),
("what", 40, 34),
("so", 41, 55),
("up", 42, 50),
("out", 43, 64),
("if", 44, 40),
("about", 45, 46),
("who", 46, 38),
("get", 47, 39),
("which", 48, 58),
("go", 49, 35),
("me", 50, 61),
("when", 51, 57),
("make", 52, 45),
("can", 53, 37),
("like", 54, 74),
("time", 55, 52),
("no", 56, 93),
("just", 57, 66),
("him", 58, 68),
("know", 59, 47),
("take", 60, 63),
("people", 61, 62),
("into", 62, 65),
("year", 63, 54),
("your", 64, 69),
("good", 65, 110),
("some", 66, 60),
("could", 67, 71),
("them", 68, 59),
("see", 69, 67),
("other", 70, 75),
("than", 71, 73),
("then", 72, 77),
("now", 73, 72),
("look", 74, 85),
("only", 75, 101),
("come", 76, 70),
("its", 77, 78),
("over", 78, 124),
("think", 79, 56),
("also", 80, 87),
("back", 81, 108),
("after", 82, 120),
("use", 83, 92),
("two", 84, 80),
("how", 85, 76),
("our", 86, 79),
("work", 87, 117),
("first", 88, 86),
("well", 89, 100),
("way", 90, 84),
("even", 91, 107),
("new", 92, 88),
("want", 93, 83),
("because", 94, 89),
("any", 95, 109),
("these", 96, 82),
("give", 97, 98),
("day", 98, 90),
("most", 99, 144),
("us", 100, 113) ON DUPLICATE KEY UPDATE `id` = `id`');

        $this->addSql('CREATE TABLE `word_supported_place` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `source_name` varchar(32) CHARACTER SET ascii NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_source_name` (`source_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

        $this->addSql("CREATE TABLE `words_total_occurrence` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `word_id` int(10) unsigned NOT NULL,
  `supported_place_id` int(10) unsigned NOT NULL,
  `appeared_times` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word_id` (`word_id`),
  KEY `supported_place_id` (`supported_place_id`),
  CONSTRAINT `words_total_occurrence_ibfk_1` FOREIGN KEY (`word_id`) REFERENCES `word` (`id`),
  CONSTRAINT `words_total_occurrence_ibfk_2` FOREIGN KEY (`supported_place_id`) REFERENCES `word_supported_place` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $this->addSql("CREATE TABLE `feed_found_word` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `external_id` int(10) unsigned NOT NULL,
  `word_id` int(10) unsigned NOT NULL,
  `supported_place_id` int(10) unsigned DEFAULT NOT NULL,
  `is_marked_for_delete` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `external_id` (`external_id`),
  KEY `word_id` (`word_id`),
  KEY `supported_place_id` (`supported_place_id`),
  CONSTRAINT `feed_found_word_ibfk_1` FOREIGN KEY (`external_id`) REFERENCES `external_id` (`id`),
  CONSTRAINT `feed_found_word_ibfk_2` FOREIGN KEY (`word_id`) REFERENCES `word` (`id`),
  CONSTRAINT `feed_found_word_ibfk_3` FOREIGN KEY (`supported_place_id`) REFERENCES `word_supported_place` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->addSql("INSERT INTO `word_supported_place` (`source_name`)
VALUES ('summary'), ('title');");


    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE IF EXISTS feed_found_word');
        $this->addSql('DROP TABLE IF EXISTS  feed_link');
        $this->addSql('DROP TABLE IF EXISTS  feed_summary');
        $this->addSql('DROP TABLE IF EXISTS  feed_title');
        $this->addSql('DROP TABLE IF EXISTS  external_id');
        $this->addSql('DROP TABLE IF EXISTS  feed_author');
        $this->addSql('DROP TABLE IF EXISTS  most_common_words');
        $this->addSql('DROP TABLE IF EXISTS  rel_collection');
        $this->addSql('DROP TABLE IF EXISTS  type_collection');
        $this->addSql('DROP TABLE IF EXISTS  `words_total_occurrence`');
        $this->addSql('DROP TABLE IF EXISTS  word');
        $this->addSql('DROP TABLE IF EXISTS  `word_supported_place`');
    }
}
