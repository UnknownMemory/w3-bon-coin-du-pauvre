<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007130445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images ADD id_annonces_id INT NOT NULL');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A543A4820 FOREIGN KEY (id_annonces_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A543A4820 ON images (id_annonces_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A543A4820');
        $this->addSql('DROP INDEX IDX_E01FBE6A543A4820 ON images');
        $this->addSql('ALTER TABLE images DROP id_annonces_id');
    }
}
