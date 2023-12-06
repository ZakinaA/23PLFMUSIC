<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204095438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument DROP FOREIGN KEY FK_3CBF69DDD23B67ED');
        $this->addSql('DROP INDEX IDX_3CBF69DDD23B67ED ON instrument');
        $this->addSql('ALTER TABLE instrument ADD nom VARCHAR(255) NOT NULL, DROP accessoire_id, CHANGE marque_id marque_id INT DEFAULT NULL, CHANGE num_serie num_serie VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE instrument_couleur MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844CF11D9C');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844C31BA576');
        $this->addSql('DROP INDEX `primary` ON instrument_couleur');
        $this->addSql('ALTER TABLE instrument_couleur DROP id, CHANGE couleur_id couleur_id INT NOT NULL, CHANGE instrument_id instrument_id INT NOT NULL');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE instrument_couleur ADD PRIMARY KEY (instrument_id, couleur_id)');
        $this->addSql('ALTER TABLE marque DROP FOREIGN KEY FK_5A6F91CECF11D9C');
        $this->addSql('DROP INDEX IDX_5A6F91CECF11D9C ON marque');
        $this->addSql('ALTER TABLE marque DROP instrument_id, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE type_instrument DROP FOREIGN KEY FK_21BCBFF8CF11D9C');
        $this->addSql('DROP INDEX IDX_21BCBFF8CF11D9C ON type_instrument');
        $this->addSql('ALTER TABLE type_instrument DROP instrument_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instrument ADD accessoire_id INT DEFAULT NULL, DROP nom, CHANGE marque_id marque_id VARCHAR(255) DEFAULT NULL, CHANGE num_serie num_serie INT NOT NULL');
        $this->addSql('ALTER TABLE instrument ADD CONSTRAINT FK_3CBF69DDD23B67ED FOREIGN KEY (accessoire_id) REFERENCES accessoire (id)');
        $this->addSql('CREATE INDEX IDX_3CBF69DDD23B67ED ON instrument (accessoire_id)');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844CF11D9C');
        $this->addSql('ALTER TABLE instrument_couleur DROP FOREIGN KEY FK_443EF844C31BA576');
        $this->addSql('ALTER TABLE instrument_couleur ADD id INT AUTO_INCREMENT NOT NULL, CHANGE instrument_id instrument_id INT DEFAULT NULL, CHANGE couleur_id couleur_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('ALTER TABLE instrument_couleur ADD CONSTRAINT FK_443EF844C31BA576 FOREIGN KEY (couleur_id) REFERENCES couleur (id)');
        $this->addSql('ALTER TABLE marque ADD instrument_id INT DEFAULT NULL, CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE marque ADD CONSTRAINT FK_5A6F91CECF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('CREATE INDEX IDX_5A6F91CECF11D9C ON marque (instrument_id)');
        $this->addSql('ALTER TABLE type_instrument ADD instrument_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE type_instrument ADD CONSTRAINT FK_21BCBFF8CF11D9C FOREIGN KEY (instrument_id) REFERENCES instrument (id)');
        $this->addSql('CREATE INDEX IDX_21BCBFF8CF11D9C ON type_instrument (instrument_id)');
    }
}
