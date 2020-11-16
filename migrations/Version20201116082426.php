<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201116082426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE president DROP CONSTRAINT fk_6e8bd214a708daff');
        $this->addSql('ALTER TABLE president ADD CONSTRAINT FK_EC7A50B7A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EC7A50B754231355A708DAFF ON president (Nom, election_id)');
        $this->addSql('ALTER INDEX idx_6e8bd214a708daff RENAME TO IDX_EC7A50B7A708DAFF');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE President DROP CONSTRAINT FK_EC7A50B7A708DAFF');
        $this->addSql('DROP INDEX UNIQ_EC7A50B754231355A708DAFF');
        $this->addSql('ALTER TABLE President ADD CONSTRAINT fk_6e8bd214a708daff FOREIGN KEY (election_id) REFERENCES election (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER INDEX idx_ec7a50b7a708daff RENAME TO idx_6e8bd214a708daff');
    }
}
