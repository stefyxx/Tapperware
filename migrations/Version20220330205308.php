<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330205308 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_produit_location (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, prototype_produit_id INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL, date_fin_teorique DATETIME DEFAULT NULL, quantite_total INT DEFAULT NULL, quantite_reste_rendre INT DEFAULT NULL, montant DOUBLE PRECISION DEFAULT NULL, montant_par_unite DOUBLE PRECISION DEFAULT NULL, INDEX IDX_558EEAF4F77D927C (panier_id), INDEX IDX_558EEAF4B82AA372 (prototype_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_produit_retour (id INT AUTO_INCREMENT NOT NULL, panier_id INT DEFAULT NULL, prototype_produit_id INT DEFAULT NULL, date_retour DATETIME DEFAULT NULL, quantite_total_a_rendre INT DEFAULT NULL, quantite_rendue INT DEFAULT NULL, montant_rendue DOUBLE PRECISION DEFAULT NULL, INDEX IDX_30C29091F77D927C (panier_id), INDEX IDX_30C29091B82AA372 (prototype_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE panier (id INT AUTO_INCREMENT NOT NULL, restaurant_id INT DEFAULT NULL, date_paiment DATETIME DEFAULT NULL, INDEX IDX_24CC0DF2B1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE prototype_produit (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, nom_produit VARCHAR(255) NOT NULL, prix_location_unitaire DOUBLE PRECISION DEFAULT NULL, taille_capacite VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, stock INT DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_433A594212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, rue VARCHAR(255) NOT NULL, numero VARCHAR(255) NOT NULL, zip VARCHAR(255) NOT NULL, numero_tva VARCHAR(255) NOT NULL, site_web VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, image VARCHAR(255) DEFAULT NULL, INDEX IDX_EB95123FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone VARCHAR(255) DEFAULT NULL, is_active TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE detail_produit_location ADD CONSTRAINT FK_558EEAF4F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE detail_produit_location ADD CONSTRAINT FK_558EEAF4B82AA372 FOREIGN KEY (prototype_produit_id) REFERENCES prototype_produit (id)');
        $this->addSql('ALTER TABLE detail_produit_retour ADD CONSTRAINT FK_30C29091F77D927C FOREIGN KEY (panier_id) REFERENCES panier (id)');
        $this->addSql('ALTER TABLE detail_produit_retour ADD CONSTRAINT FK_30C29091B82AA372 FOREIGN KEY (prototype_produit_id) REFERENCES prototype_produit (id)');
        $this->addSql('ALTER TABLE panier ADD CONSTRAINT FK_24CC0DF2B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE prototype_produit ADD CONSTRAINT FK_433A594212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prototype_produit DROP FOREIGN KEY FK_433A594212469DE2');
        $this->addSql('ALTER TABLE detail_produit_location DROP FOREIGN KEY FK_558EEAF4F77D927C');
        $this->addSql('ALTER TABLE detail_produit_retour DROP FOREIGN KEY FK_30C29091F77D927C');
        $this->addSql('ALTER TABLE detail_produit_location DROP FOREIGN KEY FK_558EEAF4B82AA372');
        $this->addSql('ALTER TABLE detail_produit_retour DROP FOREIGN KEY FK_30C29091B82AA372');
        $this->addSql('ALTER TABLE panier DROP FOREIGN KEY FK_24CC0DF2B1E7706E');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE detail_produit_location');
        $this->addSql('DROP TABLE detail_produit_retour');
        $this->addSql('DROP TABLE panier');
        $this->addSql('DROP TABLE prototype_produit');
        $this->addSql('DROP TABLE restaurant');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
