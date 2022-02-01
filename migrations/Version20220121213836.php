<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220121213836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'ajout token dans entity user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire_categorie_service ADD CONSTRAINT FK_5261E2D9BE3DB2B7 FOREIGN KEY (prestataire_id) REFERENCES prestataire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE prestataire_categorie_service ADD CONSTRAINT FK_5261E2D97395634A FOREIGN KEY (categorie_service_id) REFERENCES categorie_service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire_categorie_service DROP FOREIGN KEY FK_5261E2D9BE3DB2B7');
        $this->addSql('ALTER TABLE prestataire_categorie_service DROP FOREIGN KEY FK_5261E2D97395634A');
        $this->addSql('ALTER TABLE user DROP token');
    }
}
