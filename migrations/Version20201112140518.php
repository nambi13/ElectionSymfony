<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112140518 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE etat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE etat (id INT NOT NULL, pays_id INT NOT NULL, reference VARCHAR(40) NOT NULL, nbrevoie INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_55CAF762A6E44244 ON etat (pays_id)');
        $this->addSql('ALTER TABLE etat ADD CONSTRAINT FK_55CAF762A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE etat_id_seq CASCADE');
        $this->addSql('DROP TABLE etat');
    }
}
