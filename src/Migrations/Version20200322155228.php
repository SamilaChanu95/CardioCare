<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200322155228 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE icu (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, admit_date DATE NOT NULL, room VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, diagnosis VARCHAR(255) NOT NULL, neuro VARCHAR(255) DEFAULT NULL, cardiac VARCHAR(255) DEFAULT NULL, respiratory VARCHAR(255) DEFAULT NULL, ventilator VARCHAR(255) DEFAULT NULL, gi VARCHAR(255) DEFAULT NULL, gu VARCHAR(255) DEFAULT NULL, skin VARCHAR(255) DEFAULT NULL, drains VARCHAR(255) DEFAULT NULL, labs VARCHAR(255) DEFAULT NULL, meds VARCHAR(255) DEFAULT NULL, hemodynamics VARCHAR(255) DEFAULT NULL, to_do VARCHAR(255) DEFAULT NULL, core_measures VARCHAR(255) DEFAULT NULL, INDEX IDX_D6F8946A6B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE icu ADD CONSTRAINT FK_D6F8946A6B899279 FOREIGN KEY (patient_id) REFERENCES patient (id)');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_social_histroy p_social_histroy VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE facebook_id facebook_id VARCHAR(180) DEFAULT NULL, CHANGE facebook_access_token facebook_access_token VARCHAR(180) DEFAULT NULL, CHANGE github_id github_id VARCHAR(180) DEFAULT NULL, CHANGE github_access_token github_access_token VARCHAR(180) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE icu');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_social_histroy p_social_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_id facebook_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_access_token facebook_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_id github_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_access_token github_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
