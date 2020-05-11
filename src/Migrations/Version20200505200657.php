<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505200657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consultant CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE doctor CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE icu CHANGE diagnosis diagnosis VARCHAR(255) DEFAULT NULL, CHANGE neuro neuro VARCHAR(255) DEFAULT NULL, CHANGE cardiac cardiac VARCHAR(255) DEFAULT NULL, CHANGE respiratory respiratory VARCHAR(255) DEFAULT NULL, CHANGE ventilator ventilator VARCHAR(255) DEFAULT NULL, CHANGE gi gi VARCHAR(255) DEFAULT NULL, CHANGE gu gu VARCHAR(255) DEFAULT NULL, CHANGE skin skin VARCHAR(255) DEFAULT NULL, CHANGE drains drains VARCHAR(255) DEFAULT NULL, CHANGE labs labs VARCHAR(255) DEFAULT NULL, CHANGE meds meds VARCHAR(255) DEFAULT NULL, CHANGE hemodynamics hemodynamics VARCHAR(255) DEFAULT NULL, CHANGE to_do to_do VARCHAR(255) DEFAULT NULL, CHANGE core_measures core_measures VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE nurse CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_social_histroy p_social_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_current_location p_current_location VARCHAR(255) DEFAULT NULL, CHANGE brochure_filename brochure_filename VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E8887F4FB17');
        $this->addSql('DROP INDEX IDX_442C2E8887F4FB17 ON surgery');
        $this->addSql('ALTER TABLE surgery ADD doctor_fassistant_id INT NOT NULL, ADD doctor_sassistant_id INT NOT NULL, CHANGE doctor_id doctor_main_id INT NOT NULL');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88F1D3C427 FOREIGN KEY (doctor_main_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E881A0CA5D FOREIGN KEY (doctor_fassistant_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88A888DF94 FOREIGN KEY (doctor_sassistant_id) REFERENCES doctor (id)');
        $this->addSql('CREATE INDEX IDX_442C2E88F1D3C427 ON surgery (doctor_main_id)');
        $this->addSql('CREATE INDEX IDX_442C2E881A0CA5D ON surgery (doctor_fassistant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88A888DF94 ON surgery (doctor_sassistant_id)');
        $this->addSql('ALTER TABLE technician CHANGE photo photo VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE unit CHANGE department_id department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE facebook_id facebook_id VARCHAR(180) DEFAULT NULL, CHANGE facebook_access_token facebook_access_token VARCHAR(180) DEFAULT NULL, CHANGE github_id github_id VARCHAR(180) DEFAULT NULL, CHANGE github_access_token github_access_token VARCHAR(180) DEFAULT NULL');
        $this->addSql('ALTER TABLE ward CHANGE department_id department_id INT DEFAULT NULL, CHANGE unit_id unit_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE consultant CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE doctor CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE icu CHANGE diagnosis diagnosis VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE neuro neuro VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE cardiac cardiac VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE respiratory respiratory VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE ventilator ventilator VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE gi gi VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE gu gu VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE skin skin VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE drains drains VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE labs labs VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE meds meds VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE hemodynamics hemodynamics VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE to_do to_do VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE core_measures core_measures VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE nurse CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_social_histroy p_social_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_current_location p_current_location VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE brochure_filename brochure_filename VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88F1D3C427');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E881A0CA5D');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88A888DF94');
        $this->addSql('DROP INDEX IDX_442C2E88F1D3C427 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E881A0CA5D ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88A888DF94 ON surgery');
        $this->addSql('ALTER TABLE surgery ADD doctor_id INT NOT NULL, DROP doctor_main_id, DROP doctor_fassistant_id, DROP doctor_sassistant_id');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E8887F4FB17 FOREIGN KEY (doctor_id) REFERENCES doctor (id)');
        $this->addSql('CREATE INDEX IDX_442C2E8887F4FB17 ON surgery (doctor_id)');
        $this->addSql('ALTER TABLE technician CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE unit CHANGE department_id department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_id facebook_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_access_token facebook_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_id github_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_access_token github_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ward CHANGE department_id department_id INT DEFAULT NULL, CHANGE unit_id unit_id INT DEFAULT NULL');
    }
}
