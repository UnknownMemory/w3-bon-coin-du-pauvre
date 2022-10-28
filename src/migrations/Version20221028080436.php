<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028080436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE votes ADD vendeur_id INT NOT NULL');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_518B7ACF858C065E ON votes (vendeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF858C065E');
        $this->addSql('DROP INDEX IDX_518B7ACF858C065E ON votes');
        $this->addSql('ALTER TABLE votes DROP vendeur_id');
    }
}
