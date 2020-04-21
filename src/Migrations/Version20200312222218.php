<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200312222218 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_social_histroy p_social_histroy VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE surgery ADD nurse_id INT NOT NULL, ADD consultant_id INT NOT NULL, ADD technician_id INT NOT NULL');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E887373BFAA FOREIGN KEY (nurse_id) REFERENCES nurse (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E8844F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id)');
        $this->addSql('ALTER TABLE surgery ADD CONSTRAINT FK_442C2E88E6C5D496 FOREIGN KEY (technician_id) REFERENCES technician (id)');
        $this->addSql('CREATE INDEX IDX_442C2E887373BFAA ON surgery (nurse_id)');
        $this->addSql('CREATE INDEX IDX_442C2E8844F779A2 ON surgery (consultant_id)');
        $this->addSql('CREATE INDEX IDX_442C2E88E6C5D496 ON surgery (technician_id)');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE facebook_id facebook_id VARCHAR(180) DEFAULT NULL, CHANGE facebook_access_token facebook_access_token VARCHAR(180) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_social_histroy p_social_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E887373BFAA');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E8844F779A2');
        $this->addSql('ALTER TABLE surgery DROP FOREIGN KEY FK_442C2E88E6C5D496');
        $this->addSql('DROP INDEX IDX_442C2E887373BFAA ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E8844F779A2 ON surgery');
        $this->addSql('DROP INDEX IDX_442C2E88E6C5D496 ON surgery');
        $this->addSql('ALTER TABLE surgery DROP nurse_id, DROP consultant_id, DROP technician_id');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_id facebook_id VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE facebook_access_token facebook_access_token VARCHAR(180) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
    }
}
