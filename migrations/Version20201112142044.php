<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201112142044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE votant_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE votant (id INT NOT NULL, etat_id INT NOT NULL, election_id INT NOT NULL, president_id INT NOT NULL, nombre INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7685CA33D5E86FF ON votant (etat_id)');
        $this->addSql('CREATE INDEX IDX_7685CA33A708DAFF ON votant (election_id)');
        $this->addSql('CREATE INDEX IDX_7685CA33B40A33C7 ON votant (president_id)');
        $this->addSql('ALTER TABLE votant ADD CONSTRAINT FK_7685CA33D5E86FF FOREIGN KEY (etat_id) REFERENCES etat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votant ADD CONSTRAINT FK_7685CA33A708DAFF FOREIGN KEY (election_id) REFERENCES election (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE votant ADD CONSTRAINT FK_7685CA33B40A33C7 FOREIGN KEY (president_id) REFERENCES president (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE votant_id_seq CASCADE');
        $this->addSql('DROP TABLE votant');
    }
}
