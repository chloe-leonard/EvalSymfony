<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231226144520 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE releves (id INT AUTO_INCREMENT NOT NULL, date DATE NOT NULL, releve_brut VARCHAR(17) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lieu ADD releves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59352B2A3F FOREIGN KEY (releves_id) REFERENCES releves (id)');
        $this->addSql('CREATE INDEX IDX_2F577D59352B2A3F ON lieu (releves_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59352B2A3F');
        $this->addSql('DROP TABLE releves');
        $this->addSql('DROP INDEX IDX_2F577D59352B2A3F ON lieu');
        $this->addSql('ALTER TABLE lieu DROP releves_id');
    }
}
