<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110133714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE election_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE election (id INT NOT NULL, dateelection DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE pays ADD election_id INT NOT NULL');
        $this->addSql('ALTER TABLE pays ADD CONSTRAINT FK_349F3CAEA708DAFF FOREIGN KEY (election_id) REFERENCES election (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_349F3CAEA708DAFF ON pays (election_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pays DROP CONSTRAINT FK_349F3CAEA708DAFF');
        $this->addSql('DROP SEQUENCE election_id_seq CASCADE');
        $this->addSql('DROP TABLE election');
        $this->addSql('DROP INDEX IDX_349F3CAEA708DAFF');
        $this->addSql('ALTER TABLE pays DROP election_id');
    }
}
