<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200218053602 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE patient (id INT AUTO_INCREMENT NOT NULL, p_nic VARCHAR(50) NOT NULL, p_first_name VARCHAR(200) NOT NULL, p_last_name VARCHAR(200) NOT NULL, p_gender VARCHAR(20) NOT NULL, p_address VARCHAR(255) NOT NULL, p_dob VARCHAR(50) NOT NULL, p_height DOUBLE PRECISION NOT NULL, p_weight DOUBLE PRECISION NOT NULL, p_phone_number VARCHAR(20) NOT NULL, p_visiting_number INT NOT NULL, p_emergency_contact_details VARCHAR(255) NOT NULL, p_medical_histroy VARCHAR(255) DEFAULT NULL, p_allergic_histroy VARCHAR(255) DEFAULT NULL, p_surgical_histroy VARCHAR(255) NOT NULL, p_drug_histroy VARCHAR(255) NOT NULL, p_social_histroy VARCHAR(255) NOT NULL, p_examination_details VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE patient');
    }
}
