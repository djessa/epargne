<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210114085016 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE corporations_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE depots_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE funds_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE persons_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE rates_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE retraits_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE users_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE corporations (id INT NOT NULL, person_id INT NOT NULL, social_reason VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, piece_person VARCHAR(255) NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F3B37C7217BBB47 ON corporations (person_id)');
        $this->addSql('CREATE TABLE depots (id INT NOT NULL, fund_id INT NOT NULL, persons_id INT NOT NULL, corporations_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, is_retired BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D99EA42725A38F89 ON depots (fund_id)');
        $this->addSql('CREATE INDEX IDX_D99EA427FE812AD ON depots (persons_id)');
        $this->addSql('CREATE INDEX IDX_D99EA427D3AD0C8A ON depots (corporations_id)');
        $this->addSql('CREATE TABLE funds (id INT NOT NULL, rate_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, piece_obtaining VARCHAR(255) NOT NULL, duration INT NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6654D51BC999F9F ON funds (rate_id)');
        $this->addSql('CREATE TABLE persons (id INT NOT NULL, name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, identity VARCHAR(255) NOT NULL, cin_recto VARCHAR(255) NOT NULL, cin_verso VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, certificat VARCHAR(255) NOT NULL, tel VARCHAR(10) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE rates (id INT NOT NULL, year INT NOT NULL, month VARCHAR(255) NOT NULL, value_of_one DOUBLE PRECISION NOT NULL, value_of_two DOUBLE PRECISION NOT NULL, value_of_three DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE retraits (id INT NOT NULL, person_id INT NOT NULL, fund_id INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7BB2A03217BBB47 ON retraits (person_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7BB2A0325A38F89 ON retraits (fund_id)');
        $this->addSql('CREATE TABLE users (id INT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, is_admin BOOLEAN DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE corporations ADD CONSTRAINT FK_6F3B37C7217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA42725A38F89 FOREIGN KEY (fund_id) REFERENCES funds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427D3AD0C8A FOREIGN KEY (corporations_id) REFERENCES corporations (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE funds ADD CONSTRAINT FK_6654D51BC999F9F FOREIGN KEY (rate_id) REFERENCES rates (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE retraits ADD CONSTRAINT FK_7BB2A03217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE retraits ADD CONSTRAINT FK_7BB2A0325A38F89 FOREIGN KEY (fund_id) REFERENCES funds (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE depots DROP CONSTRAINT FK_D99EA427D3AD0C8A');
        $this->addSql('ALTER TABLE depots DROP CONSTRAINT FK_D99EA42725A38F89');
        $this->addSql('ALTER TABLE retraits DROP CONSTRAINT FK_7BB2A0325A38F89');
        $this->addSql('ALTER TABLE corporations DROP CONSTRAINT FK_6F3B37C7217BBB47');
        $this->addSql('ALTER TABLE depots DROP CONSTRAINT FK_D99EA427FE812AD');
        $this->addSql('ALTER TABLE retraits DROP CONSTRAINT FK_7BB2A03217BBB47');
        $this->addSql('ALTER TABLE funds DROP CONSTRAINT FK_6654D51BC999F9F');
        $this->addSql('DROP SEQUENCE corporations_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE depots_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE funds_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE persons_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE rates_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE retraits_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE users_id_seq CASCADE');
        $this->addSql('DROP TABLE corporations');
        $this->addSql('DROP TABLE depots');
        $this->addSql('DROP TABLE funds');
        $this->addSql('DROP TABLE persons');
        $this->addSql('DROP TABLE rates');
        $this->addSql('DROP TABLE retraits');
        $this->addSql('DROP TABLE users');
    }
}
