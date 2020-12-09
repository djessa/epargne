<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205210251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE depots_persons');
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA427B2685369');
        $this->addSql('DROP INDEX IDX_D99EA427B2685369 ON depots');
        $this->addSql('ALTER TABLE depots ADD persons_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE corporation_id corporations_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id)');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427D3AD0C8A FOREIGN KEY (corporations_id) REFERENCES corporations (id)');
        $this->addSql('CREATE INDEX IDX_D99EA427FE812AD ON depots (persons_id)');
        $this->addSql('CREATE INDEX IDX_D99EA427D3AD0C8A ON depots (corporations_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depots_persons (depots_id INT NOT NULL, persons_id INT NOT NULL, INDEX IDX_35CAD087869F5222 (depots_id), INDEX IDX_35CAD087FE812AD (persons_id), PRIMARY KEY(depots_id, persons_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE depots_persons ADD CONSTRAINT FK_35CAD087869F5222 FOREIGN KEY (depots_id) REFERENCES depots (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE depots_persons ADD CONSTRAINT FK_35CAD087FE812AD FOREIGN KEY (persons_id) REFERENCES persons (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA427FE812AD');
        $this->addSql('ALTER TABLE depots DROP FOREIGN KEY FK_D99EA427D3AD0C8A');
        $this->addSql('DROP INDEX IDX_D99EA427FE812AD ON depots');
        $this->addSql('DROP INDEX IDX_D99EA427D3AD0C8A ON depots');
        $this->addSql('ALTER TABLE depots DROP persons_id, CHANGE created_at created_at TIME NOT NULL, CHANGE corporations_id corporation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depots ADD CONSTRAINT FK_D99EA427B2685369 FOREIGN KEY (corporation_id) REFERENCES corporations (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D99EA427B2685369 ON depots (corporation_id)');
    }
}
