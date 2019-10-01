<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190927095456 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE diving (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) NOT NULL, date DATE NOT NULL, description LONGTEXT NOT NULL, places INT NOT NULL, level_min VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, fk_id_member_id INT DEFAULT NULL, fk_id_diving_id INT NOT NULL, regulator TINYINT(1) NOT NULL, wet_suit TINYINT(1) NOT NULL, size_suit VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_42C84955D47F6DC0 (fk_id_member_id), UNIQUE INDEX UNIQ_42C84955307A609F (fk_id_diving_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, user_name VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, level_dive VARCHAR(255) NOT NULL, instructor VARCHAR(255) DEFAULT NULL, birthday_date DATE NOT NULL, mail VARCHAR(255) DEFAULT NULL, adress VARCHAR(255) NOT NULL, cp INT NOT NULL, city VARCHAR(255) NOT NULL, phone1 VARCHAR(255) NOT NULL, phone2 VARCHAR(255) NOT NULL, num_license INT NOT NULL, boat_license TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, fk_id_member_id INT NOT NULL, password VARCHAR(255) NOT NULL, access VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7D3656A4D47F6DC0 (fk_id_member_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D47F6DC0 FOREIGN KEY (fk_id_member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955307A609F FOREIGN KEY (fk_id_diving_id) REFERENCES diving (id)');
        $this->addSql('ALTER TABLE account ADD CONSTRAINT FK_7D3656A4D47F6DC0 FOREIGN KEY (fk_id_member_id) REFERENCES member (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955307A609F');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D47F6DC0');
        $this->addSql('ALTER TABLE account DROP FOREIGN KEY FK_7D3656A4D47F6DC0');
        $this->addSql('DROP TABLE diving');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE member');
        $this->addSql('DROP TABLE account');
    }
}
