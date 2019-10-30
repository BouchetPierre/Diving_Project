<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191004143604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE diving (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) NOT NULL, date DATETIME NOT NULL, description LONGTEXT NOT NULL, places INT NOT NULL, level_min VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role_member (role_id INT NOT NULL, member_id INT NOT NULL, INDEX IDX_DBC21BC9D60322AC (role_id), INDEX IDX_DBC21BC97597D3FE (member_id), PRIMARY KEY(role_id, member_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, fk_id_member_id INT DEFAULT NULL, fk_id_diving_id INT NOT NULL, regulator TINYINT(1) NOT NULL, wet_suit TINYINT(1) NOT NULL, size_suit VARCHAR(255) DEFAULT NULL, INDEX IDX_42C84955D47F6DC0 (fk_id_member_id), UNIQUE INDEX UNIQ_42C84955307A609F (fk_id_diving_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, level_dive VARCHAR(255) NOT NULL, instructor VARCHAR(255) DEFAULT NULL, birthday_date DATETIME NOT NULL, mail VARCHAR(255) DEFAULT NULL, address VARCHAR(255) NOT NULL, cp INT NOT NULL, city VARCHAR(255) NOT NULL, phone1 VARCHAR(255) NOT NULL, phone2 VARCHAR(255) NOT NULL, num_license INT NOT NULL, boat_license TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE role_member ADD CONSTRAINT FK_DBC21BC9D60322AC FOREIGN KEY (role_id) REFERENCES role (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE role_member ADD CONSTRAINT FK_DBC21BC97597D3FE FOREIGN KEY (member_id) REFERENCES member (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D47F6DC0 FOREIGN KEY (fk_id_member_id) REFERENCES member (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955307A609F FOREIGN KEY (fk_id_diving_id) REFERENCES diving (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955307A609F');
        $this->addSql('ALTER TABLE role_member DROP FOREIGN KEY FK_DBC21BC9D60322AC');
        $this->addSql('ALTER TABLE role_member DROP FOREIGN KEY FK_DBC21BC97597D3FE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D47F6DC0');
        $this->addSql('DROP TABLE diving');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE role_member');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE member');
    }
}
