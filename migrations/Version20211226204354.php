<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211226204354 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création relation categorieService-image';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_service ADD images_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE categorie_service ADD CONSTRAINT FK_BE1E3470D44F05E5 FOREIGN KEY (images_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BE1E3470D44F05E5 ON categorie_service (images_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie_service DROP FOREIGN KEY FK_BE1E3470D44F05E5');
        $this->addSql('DROP INDEX UNIQ_BE1E3470D44F05E5 ON categorie_service');
        $this->addSql('ALTER TABLE categorie_service DROP images_id');
    }
}
