<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221018155515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A543A4820');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4543A4820');
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, date DATE NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_F65593E5858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_tag (annonce_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C304E7E28805AB2F (annonce_id), INDEX IDX_C304E7E2BAD26311 (tag_id), PRIMARY KEY(annonce_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce_tag ADD CONSTRAINT FK_C304E7E28805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_tag ADD CONSTRAINT FK_C304E7E2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEF8D7B4FB4');
        $this->addSql('ALTER TABLE annonces_tags DROP FOREIGN KEY FK_557AEAEF4C2885D7');
        $this->addSql('ALTER TABLE annonces DROP FOREIGN KEY FK_CB988C6F376858A8');
        $this->addSql('DROP TABLE tags');
        $this->addSql('DROP TABLE annonces_tags');
        $this->addSql('DROP TABLE annonces');
        $this->addSql('DROP INDEX IDX_D9BEC0C4543A4820 ON commentaires');
        $this->addSql('ALTER TABLE commentaires ADD annonce_id INT DEFAULT NULL, DROP id_annonces_id');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C48805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C48805AB2F ON commentaires (annonce_id)');
        $this->addSql('DROP INDEX IDX_E01FBE6A543A4820 ON images');
        $this->addSql('ALTER TABLE images ADD annonce_id INT DEFAULT NULL, DROP id_annonces_id');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A8805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A8805AB2F ON images (annonce_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C48805AB2F');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A8805AB2F');
        $this->addSql('CREATE TABLE tags (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE annonces_tags (annonces_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_557AEAEF4C2885D7 (annonces_id), INDEX IDX_557AEAEF8D7B4FB4 (tags_id), PRIMARY KEY(annonces_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE annonces (id INT AUTO_INCREMENT NOT NULL, id_users_id INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, date DATE NOT NULL, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_CB988C6F376858A8 (id_users_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEF8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces_tags ADD CONSTRAINT FK_557AEAEF4C2885D7 FOREIGN KEY (annonces_id) REFERENCES annonces (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonces ADD CONSTRAINT FK_CB988C6F376858A8 FOREIGN KEY (id_users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5858C065E');
        $this->addSql('ALTER TABLE annonce_tag DROP FOREIGN KEY FK_C304E7E28805AB2F');
        $this->addSql('ALTER TABLE annonce_tag DROP FOREIGN KEY FK_C304E7E2BAD26311');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_tag');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP INDEX IDX_E01FBE6A8805AB2F ON images');
        $this->addSql('ALTER TABLE images ADD id_annonces_id INT NOT NULL, DROP annonce_id');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A543A4820 FOREIGN KEY (id_annonces_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_E01FBE6A543A4820 ON images (id_annonces_id)');
        $this->addSql('DROP INDEX IDX_D9BEC0C48805AB2F ON commentaires');
        $this->addSql('ALTER TABLE commentaires ADD id_annonces_id INT NOT NULL, DROP annonce_id');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4543A4820 FOREIGN KEY (id_annonces_id) REFERENCES annonces (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4543A4820 ON commentaires (id_annonces_id)');
    }
}
