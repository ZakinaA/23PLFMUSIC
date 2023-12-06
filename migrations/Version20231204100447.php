<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204100447 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_pret (id INT AUTO_INCREMENT NOT NULL, instrument_id INT DEFAULT NULL, eleve_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, attestation_assurance VARCHAR(255) NOT NULL, etat_detaille_debut LONGTEXT NOT NULL, etat_detaille_retour LONGTEXT DEFAULT NULL, INDEX IDX_1FB84C67CF11D9C (instrument_id), INDEX IDX_1FB84C67A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inter_pret (id INT AUTO_INCREMENT NOT NULL, intervention_id INT DEFAULT NULL, contrat_pret_id INT DEFAULT NULL, quotite NUMERIC(10, 3) NOT NULL, INDEX IDX_244C23678EAE3863 (intervention_id), INDEX IDX_244C2367B2AF233D (contrat_pret_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE responsable (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, num_rue INT NOT NULL, rue VARCHAR(255) NOT NULL, copos INT NOT NULL, ville VARCHAR(255) NOT NULL, tel INT NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat_pret ADD CONSTRAINT FK_1FB84C67CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE contrat_pret ADD CONSTRAINT FK_1FB84C67A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE inter_pret ADD CONSTRAINT FK_244C23678EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id)');
        $this->addSql('ALTER TABLE inter_pret ADD CONSTRAINT FK_244C2367B2AF233D FOREIGN KEY (contrat_pret_id) REFERENCES contrat_pret (id)');
        $this->addSql('ALTER TABLE instrument CHANGE marque_id marque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE instrument_couleur MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844CF11D9C');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844C31BA576');
        $this->addSql('DROP INDEX `primary` ON instrument_couleur');
        $this->addSql('ALTER TABLE instrument_couleur DROP id, CHANGE couleur_id couleur_id INT NOT NULL, CHANGE instrument_id instrument_id INT NOT NULL');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_couleur ADD PRIMARY KEY (instrument_id, couleur_id)');
        $this->addSql('ALTER TABLE marque CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_pret DROP FOREIGN KEY FK_1FB84C67CF11D9C');
        $this->addSql('ALTER TABLE contrat_pret DROP FOREIGN KEY FK_1FB84C67A6CC7B2');
        $this->addSql('ALTER TABLE inter_pret DROP FOREIGN KEY FK_244C23678EAE3863');
        $this->addSql('ALTER TABLE inter_pret DROP FOREIGN KEY FK_244C2367B2AF233D');
        $this->addSql('DROP TABLE contrat_pret');
        $this->addSql('DROP TABLE inter_pret');
        $this->addSql('DROP TABLE responsable');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE instrument CHANGE marque_id marque_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844CF11D9C');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844C31BA576');
        $this->addSql('ALTER TABLE instrument_couleur ADD id INT AUTO_INCREMENT NOT NULL, CHANGE instrument_id instrument_id INT DEFAULT NULL, CHANGE couleur_id couleur_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
        $this->addSql('ALTER TABLE marque CHANGE id id VARCHAR(255) NOT NULL');
    }
}
