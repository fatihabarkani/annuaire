<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129142319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'relation image<->internaute';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internaute ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE internaute ADD CONSTRAINT FK_6C8E97CC3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6C8E97CC3DA5256D ON internaute (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE internaute DROP FOREIGN KEY FK_6C8E97CC3DA5256D');
        $this->addSql('DROP INDEX UNIQ_6C8E97CC3DA5256D ON internaute');
        $this->addSql('ALTER TABLE internaute DROP image_id');
    }
}
