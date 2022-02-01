<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221205455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'creation relation user-localite';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD localite_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649924DD2B5 FOREIGN KEY (localite_id) REFERENCES localite (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649924DD2B5 ON user (localite_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649924DD2B5');
        $this->addSql('DROP INDEX IDX_8D93D649924DD2B5 ON user');
        $this->addSql('ALTER TABLE user DROP localite_id');
    }
}
