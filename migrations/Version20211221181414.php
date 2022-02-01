<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221181414 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création de la relation commune user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD commune_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649131A4F72 FOREIGN KEY (commune_id) REFERENCES commune (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649131A4F72 ON user (commune_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649131A4F72');
        $this->addSql('DROP INDEX IDX_8D93D649131A4F72 ON user');
        $this->addSql('ALTER TABLE user DROP commune_id');
    }
}
