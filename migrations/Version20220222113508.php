<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220222113508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE screen ADD projet_id INT NOT NULL');
        $this->addSql('ALTER TABLE screen ADD CONSTRAINT FK_DF4C6130C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_DF4C6130C18272 ON screen (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE contexte contexte LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE besoin besoin LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE bilan bilan LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE doc doc VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE screen DROP FOREIGN KEY FK_DF4C6130C18272');
        $this->addSql('DROP INDEX IDX_DF4C6130C18272 ON screen');
        $this->addSql('ALTER TABLE screen DROP projet_id, CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE techno CHANGE nom nom VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
