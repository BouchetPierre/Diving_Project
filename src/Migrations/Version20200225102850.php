<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200225102850 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

      #  $this->addSql('ALTER TABLE reservation DROP INDEX UNIQ_42C84955307A609F, ADD INDEX IDX_42C84955307A609F (fk_id_diving_id)');
        $this->addSql('ALTER TABLE reservation CHANGE fk_id_member_id fk_id_member_id INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX resa_idx ON reservation (fk_id_member_id, fk_id_diving_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE reservation DROP INDEX IDX_42C84955307A609F, ADD UNIQUE INDEX UNIQ_42C84955307A609F (fk_id_diving_id)');
        $this->addSql('DROP INDEX resa_idx ON reservation');
        $this->addSql('ALTER TABLE reservation CHANGE fk_id_member_id fk_id_member_id INT DEFAULT NULL');
    }
}
