<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201110135256 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE election (id INT NOT NULL, pays_id INT NOT NULL, date_election DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DCA03800A6E44244 ON election (pays_id)');
        $this->addSql('CREATE TABLE pays (id INT NOT NULL, nompays VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE election ADD CONSTRAINT FK_DCA03800A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE election DROP CONSTRAINT FK_DCA03800A6E44244');
        $this->addSql('DROP TABLE election');
        $this->addSql('DROP TABLE pays');
    }
}
