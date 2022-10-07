<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007134803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD id_votes_id INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493D3335D FOREIGN KEY (id_votes_id) REFERENCES votes (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D6493D3335D ON user (id_votes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493D3335D');
        $this->addSql('DROP INDEX UNIQ_8D93D6493D3335D ON user');
        $this->addSql('ALTER TABLE user DROP id_votes_id');
    }
}
