<?php /** @noinspection SqlResolve */
/** @noinspection SqlNoDataSourceInspection */

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class CustomSQL extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE DATABASE IF NOT EXISTS `mintos_test_task`");
        $this->addSql("ALTER DATABASE `mintos_test_task` COLLATE 'utf8mb4_general_ci';");

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

        //TODO update SQL
        "CREATE TABLE `feed_author` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `full_name` varchar(128) NOT NULL,
  `homepage_uri` varchar(128) NOT NULL,
  `email_address` varchar(128) NOT NULL,
  `created` datetime NOT NULL
) ENGINE='InnoDB';";

        "CREATE TABLE `external_id` (
  `id` int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `external_id` varchar(128) COLLATE 'utf8_bin' NOT NULL,
  `imported` datetime NOT NULL
) ENGINE='InnoDB';";
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE IF EXISTS `most_common_words`');

    }
}
