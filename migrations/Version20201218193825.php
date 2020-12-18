<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201218193825 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE corporations (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, social_reason VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, piece_person VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6F3B37C7217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depots (id INT AUTO_INCREMENT NOT NULL, fund_id INT NOT NULL, persons_id INT NOT NULL, corporations_id INT DEFAULT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_D99EA42725A38F89 (fund_id), INDEX IDX_D99EA427FE812AD (persons_id), INDEX IDX_D99EA427D3AD0C8A (corporations_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE funds (id INT AUTO_INCREMENT NOT NULL, rate_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, piece_obtaining VARCHAR(255) NOT NULL, duration INT NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_6654D51BC999F9F (rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE persons (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, identity VARCHAR(255) NOT NULL, cin_recto VARCHAR(255) NOT NULL, cin_verso VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, certificat VARCHAR(255) NOT NULL, tel VARCHAR(10) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rates (id INT AUTO_INCREMENT NOT NULL, year INT NOT NULL, month VARCHAR(255) NOT NULL, value_of_one DOUBLE PRECISION NOT NULL, value_of_two DOUBLE PRECISION NOT NULL, value_of_three DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE retraits (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, fund_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_7BB2A03217BBB47 (person_id), UNIQUE INDEX UNIQ_7BB2A0325A38F89 (fund_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE corporations ADD CONSTRAINT FK_6F3B37C7217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA42725A38F89 FOREIGN KEY (fund_id) REFERENCES funds (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427D3AD0C8A FOREIGN KEY (corporations_id) REFERENCES corporations (id)');
        $this->addSql('ALTER TABLE funds ADD CONSTRAINT FK_6654D51BC999F9F FOREIGN KEY (rate_id) REFERENCES rates (id)');
        $this->addSql('ALTER TABLE retraits ADD CONSTRAINT FK_7BB2A03217BBB47 FOREIGN KEY (person_id) REFERENCES persons (id)');
        $this->addSql('ALTER TABLE retraits ADD CONSTRAINT FK_7BB2A0325A38F89 FOREIGN KEY (fund_id) REFERENCES funds (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA427D3AD0C8A');
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA42725A38F89');
        $this->addSql('ALTER TABLE retraits DROP FOREIGN KEY FK_7BB2A0325A38F89');
        $this->addSql('ALTER TABLE corporations DROP FOREIGN KEY FK_6F3B37C7217BBB47');
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA427FE812AD');
        $this->addSql('ALTER TABLE retraits DROP FOREIGN KEY FK_7BB2A03217BBB47');
        $this->addSql('ALTER TABLE funds DROP FOREIGN KEY FK_6654D51BC999F9F');
        $this->addSql('DROP TABLE corporations');
        $this->addSql('DROP TABLE depots');
        $this->addSql('DROP TABLE funds');
        $this->addSql('DROP TABLE persons');
        $this->addSql('DROP TABLE rates');
        $this->addSql('DROP TABLE retraits');
    }
}
