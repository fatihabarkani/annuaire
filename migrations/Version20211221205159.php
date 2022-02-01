<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221205159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'création relation codePostal-user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire DROP code_postal_id');
        $this->addSql('ALTER TABLE user ADD code_postal_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B2B59251 FOREIGN KEY (code_postal_id) REFERENCES code_postal (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649B2B59251 ON user (code_postal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prestataire ADD code_postal_id INT NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B2B59251');
        $this->addSql('DROP INDEX IDX_8D93D649B2B59251 ON user');
        $this->addSql('ALTER TABLE user DROP code_postal_id');
    }
}
