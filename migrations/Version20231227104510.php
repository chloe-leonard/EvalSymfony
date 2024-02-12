<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231227104510 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu DROP FOREIGN KEY FK_2F577D59352B2A3F');
        $this->addSql('DROP INDEX IDX_2F577D59352B2A3F ON lieu');
        $this->addSql('ALTER TABLE lieu DROP releves_id');
        $this->addSql('ALTER TABLE releves ADD lieu_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE releves ADD CONSTRAINT FK_6F62B66EBA74394C FOREIGN KEY (lieu_id_id) REFERENCES lieu (id)');
        $this->addSql('CREATE INDEX IDX_6F62B66EBA74394C ON releves (lieu_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE lieu ADD releves_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lieu ADD CONSTRAINT FK_2F577D59352B2A3F FOREIGN KEY (releves_id) REFERENCES releves (id)');
        $this->addSql('CREATE INDEX IDX_2F577D59352B2A3F ON lieu (releves_id)');
        $this->addSql('ALTER TABLE releves DROP FOREIGN KEY FK_6F62B66EBA74394C');
        $this->addSql('DROP INDEX IDX_6F62B66EBA74394C ON releves');
        $this->addSql('ALTER TABLE releves DROP lieu_id_id');
    }
}
