<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200505205741 extends AbstractMigration
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
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E8844F779A2');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E887373BFAA');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88E6C5D496');
        $this->addSql('DROP INDEX IDX_442C2E887373BFAA ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E8844F779A2 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88E6C5D496 ON surgery');
        $this->addSql('ALTER TABLE surgery ADD doctor_anesthetist_id INT DEFAULT NULL, ADD nurse_main_id INT NOT NULL, ADD nurse_fassistant_id INT NOT NULL, ADD nurse_sassistant_id INT NOT NULL, ADD nurse_tassistant_id INT NOT NULL, ADD consultant_main_id INT NOT NULL, ADD consultant_assistant_id INT NOT NULL, ADD technician_main_id INT NOT NULL, ADD technician_assistant_id INT NOT NULL, DROP nurse_id, DROP consultant_id, DROP technician_id, CHANGE doctor_fassistant_id doctor_fassistant_id INT DEFAULT NULL, CHANGE doctor_sassistant_id doctor_sassistant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E8818F28776 FOREIGN KEY (doctor_anesthetist_id) REFERENCES doctor (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E889958EE54 FOREIGN KEY (nurse_main_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E887BFB2935 FOREIGN KEY (nurse_fassistant_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88D2D33CFC FOREIGN KEY (nurse_sassistant_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88AFA03AA4 FOREIGN KEY (nurse_tassistant_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E888C350727 FOREIGN KEY (consultant_main_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E8899BD798E FOREIGN KEY (consultant_assistant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88DC4B372C FOREIGN KEY (technician_main_id) REFERENCES technician (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88FA92A830 FOREIGN KEY (technician_assistant_id) REFERENCES technician (id)');
        $this->addSql('CREATE INDEX IDX_442C2E8818F28776 ON surgery (doctor_anesthetist_id)');
        $this->addSql('CREATE INDEX IDX_442C2E889958EE54 ON surgery (nurse_main_id)');
        $this->addSql('CREATE INDEX IDX_442C2E887BFB2935 ON surgery (nurse_fassistant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88D2D33CFC ON surgery (nurse_sassistant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88AFA03AA4 ON surgery (nurse_tassistant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E888C350727 ON surgery (consultant_main_id)');
        $this->addSql('CREATE INDEX IDX_442C2E8899BD798E ON surgery (consultant_assistant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88DC4B372C ON surgery (technician_main_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88FA92A830 ON surgery (technician_assistant_id)');
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
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E8818F28776');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E889958EE54');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E887BFB2935');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88D2D33CFC');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88AFA03AA4');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E888C350727');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E8899BD798E');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88DC4B372C');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88FA92A830');
        $this->addSql('DROP INDEX IDX_442C2E8818F28776 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E889958EE54 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E887BFB2935 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88D2D33CFC ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88AFA03AA4 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E888C350727 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E8899BD798E ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88DC4B372C ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88FA92A830 ON surgery');
        $this->addSql('ALTER TABLE surgery ADD nurse_id INT NOT NULL, ADD consultant_id INT NOT NULL, ADD technician_id INT NOT NULL, DROP doctor_anesthetist_id, DROP nurse_main_id, DROP nurse_fassistant_id, DROP nurse_sassistant_id, DROP nurse_tassistant_id, DROP consultant_main_id, DROP consultant_assistant_id, DROP technician_main_id, DROP technician_assistant_id, CHANGE doctor_fassistant_id doctor_fassistant_id INT DEFAULT NULL, CHANGE doctor_sassistant_id doctor_sassistant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E8844F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E887373BFAA FOREIGN KEY (nurse_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88E6C5D496 FOREIGN KEY (technician_id) REFERENCES technician (id)');
        $this->addSql('CREATE INDEX IDX_442C2E887373BFAA ON surgery (nurse_id)');
        $this->addSql('CREATE INDEX IDX_442C2E8844F779A2 ON surgery (consultant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88E6C5D496 ON surgery (technician_id)');
        $this->addSql('ALTER TABLE technician CHANGE photo photo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE unit CHANGE department_id department_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_id facebook_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_access_token facebook_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_id github_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE github_access_token github_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ward CHANGE department_id department_id INT DEFAULT NULL, CHANGE unit_id unit_id INT DEFAULT NULL');
    }
}
