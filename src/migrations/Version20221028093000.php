<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221028093000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE annonce (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, prix DOUBLE PRECISION NOT NULL, date DATE NOT NULL, slug VARCHAR(255) NOT NULL, images LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_F65593E5858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annonce_tag (annonce_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C304E7E28805AB2F (annonce_id), INDEX IDX_C304E7E2BAD26311 (tag_id), PRIMARY KEY(annonce_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, annonce_id INT DEFAULT NULL, message LONGTEXT NOT NULL, date_publication DATE NOT NULL, INDEX IDX_D9BEC0C479F37AE5 (id_user_id), INDEX IDX_D9BEC0C48805AB2F (annonce_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_votes_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D6493D3335D (id_votes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE votes (id INT AUTO_INCREMENT NOT NULL, vendeur_id INT NOT NULL, a_voter TINYINT(1) NOT NULL, INDEX IDX_518B7ACF858C065E (vendeur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE votes_user (votes_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F1B101D45308DFC8 (votes_id), INDEX IDX_F1B101D4A76ED395 (user_id), PRIMARY KEY(votes_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE annonce ADD CONSTRAINT FK_F65593E5858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE annonce_tag ADD CONSTRAINT FK_C304E7E28805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE annonce_tag ADD CONSTRAINT FK_C304E7E2BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C479F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C48805AB2F FOREIGN KEY (annonce_id) REFERENCES annonce (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6493D3335D FOREIGN KEY (id_votes_id) REFERENCES votes (id)');
        $this->addSql('ALTER TABLE votes ADD CONSTRAINT FK_518B7ACF858C065E FOREIGN KEY (vendeur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE votes_user ADD CONSTRAINT FK_F1B101D45308DFC8 FOREIGN KEY (votes_id) REFERENCES votes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE votes_user ADD CONSTRAINT FK_F1B101D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE annonce DROP FOREIGN KEY FK_F65593E5858C065E');
        $this->addSql('ALTER TABLE annonce_tag DROP FOREIGN KEY FK_C304E7E28805AB2F');
        $this->addSql('ALTER TABLE annonce_tag DROP FOREIGN KEY FK_C304E7E2BAD26311');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C479F37AE5');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C48805AB2F');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6493D3335D');
        $this->addSql('ALTER TABLE votes DROP FOREIGN KEY FK_518B7ACF858C065E');
        $this->addSql('ALTER TABLE votes_user DROP FOREIGN KEY FK_F1B101D45308DFC8');
        $this->addSql('ALTER TABLE votes_user DROP FOREIGN KEY FK_F1B101D4A76ED395');
        $this->addSql('DROP TABLE annonce');
        $this->addSql('DROP TABLE annonce_tag');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE votes');
        $this->addSql('DROP TABLE votes_user');
    }
}
