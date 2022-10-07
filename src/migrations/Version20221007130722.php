<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221007130722 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonces_tags (annonces_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_557AEAEF4C2885D7 (annonces_id), INDEX IDX_557AEAEF8D7B4FB4 (tags_id), PRIMARY KEY(annonces_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEF4C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEF8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEF4C2885D7');
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEF8D7B4FB4');
        $this->addSql('DROP TABLE annonces_tags');
    }
}
