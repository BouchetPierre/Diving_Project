<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009104450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('DROP TABLE reservation_diving');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE reservation_diving (reservation_id INT NOT NULL, diving_id INT NOT NULL, INDEX IDX_DF8E0D75B83297E7 (reservation_id), INDEX IDX_DF8E0D759192DEA1 (diving_id), PRIMARY KEY(reservation_id, diving_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE reservation_diving ADD CONSTRAINT FK_DF8E0D759192DEA1 FOREIGN KEY (diving_id) REFERENCES diving (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation_diving ADD CONSTRAINT FK_DF8E0D75B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
    }
}
