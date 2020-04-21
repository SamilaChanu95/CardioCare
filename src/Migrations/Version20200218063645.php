<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218063645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE surgery_nurse (surgery_id INT NOT NULL, nurse_id INT NOT NULL, INDEX IDX_4923B395B0B8EA83 (surgery_id), INDEX IDX_4923B3957373BFAA (nurse_id), PRIMARY KEY(surgery_id, nurse_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surgery_consultant (surgery_id INT NOT NULL, consultant_id INT NOT NULL, INDEX IDX_72FD28C0B0B8EA83 (surgery_id), INDEX IDX_72FD28C044F779A2 (consultant_id), PRIMARY KEY(surgery_id, consultant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surgery_technician (surgery_id INT NOT NULL, technician_id INT NOT NULL, INDEX IDX_C4AB4329B0B8EA83 (surgery_id), INDEX IDX_C4AB4329E6C5D496 (technician_id), PRIMARY KEY(surgery_id, technician_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE surgery_nurse ADD CONSTRAINT FK_4923B395B0B8EA83 FOREIGN KEY (surgery_id) REFERENCES surgery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surgery_nurse ADD CONSTRAINT FK_4923B3957373BFAA FOREIGN KEY (nurse_id) REFERENCES nurse (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surgery_consultant ADD CONSTRAINT FK_72FD28C0B0B8EA83 FOREIGN KEY (surgery_id) REFERENCES surgery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surgery_consultant ADD CONSTRAINT FK_72FD28C044F779A2 FOREIGN KEY (consultant_id) REFERENCES consultant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surgery_technician ADD CONSTRAINT FK_C4AB4329B0B8EA83 FOREIGN KEY (surgery_id) REFERENCES surgery (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surgery_technician ADD CONSTRAINT FK_C4AB4329E6C5D496 FOREIGN KEY (technician_id) REFERENCES technician (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) DEFAULT NULL, CHANGE p_social_histroy p_social_histroy VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE surgery ADD time TIME NOT NULL, ADD date DATE NOT NULL, CHANGE name name VARCHAR(200) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE surgery_nurse');
        $this->addSql('DROP TABLE surgery_consultant');
        $this->addSql('DROP TABLE surgery_technician');
        $this->addSql('ALTER TABLE patient CHANGE p_medical_histroy p_medical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_allergic_histroy p_allergic_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_surgical_histroy p_surgical_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_drug_histroy p_drug_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, CHANGE p_social_histroy p_social_histroy VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE surgery DROP time, DROP date, CHANGE name name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
