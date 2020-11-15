<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201111133011 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE president_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE president (id INT NOT NULL, election_id INT NOT NULL, nom VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6E8BD214A708DAFF ON president (election_id)');
        $this->addSql('ALTER TABLE president ADD CONSTRAINT FK_6E8BD214A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE president_id_seq CASCADE');
        $this->addSql('DROP TABLE president');
    }
}
