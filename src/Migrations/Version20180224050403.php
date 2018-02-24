<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224050403 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE applicant (id INTEGER NOT NULL, applicant_job_id INTEGER DEFAULT NULL, application_id INTEGER DEFAULT NULL, salutation CLOB DEFAULT NULL, birth_date DATE DEFAULT NULL, civil_status CLOB DEFAULT NULL, nationality CLOB DEFAULT NULL, current_landlord CLOB DEFAULT NULL, given_name CLOB NOT NULL, family_name CLOB NOT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, telephone CLOB DEFAULT NULL, email CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAAD1019920427E9 ON applicant (applicant_job_id)');
        $this->addSql('CREATE INDEX IDX_CAAD10193E030ACD ON applicant (application_id)');
        $this->addSql('CREATE TABLE applicant_job (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, profession CLOB DEFAULT NULL, yearly_salary INTEGER DEFAULT NULL, working_since DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E79CAB6D1645DEA9 ON applicant_job (reference_id)');
        $this->addSql('CREATE TABLE applicant_landlord (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, relocation_reason CLOB DEFAULT NULL, renting_since DATE DEFAULT NULL, notice_by CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3051E7E51645DEA9 ON applicant_landlord (reference_id)');
        $this->addSql('CREATE TABLE applicant_reference (id INTEGER NOT NULL, applicant_id INTEGER DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, given_name CLOB NOT NULL, family_name CLOB NOT NULL, telephone CLOB DEFAULT NULL, email CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CD6132C597139001 ON applicant_reference (applicant_id)');
        $this->addSql('CREATE TABLE company (id INTEGER NOT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP INDEX IDX_4D7E68544D2A7E12');
        $this->addSql('CREATE TEMPORARY TABLE __temp__apartment AS SELECT id, building_id, name, description FROM apartment');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('CREATE TABLE apartment (id INTEGER NOT NULL, building_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_4D7E68544D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO apartment (id, building_id, name, description) SELECT id, building_id, name, description FROM __temp__apartment');
        $this->addSql('DROP TABLE __temp__apartment');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('ALTER TABLE application ADD COLUMN pets CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE application ADD COLUMN instruments CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_5BE248EF176DFE85');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_slot AS SELECT id, apartment_id, name, description FROM application_slot');
        $this->addSql('DROP TABLE application_slot');
        $this->addSql('CREATE TABLE application_slot (id INTEGER NOT NULL, apartment_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, identifier CLOB DEFAULT NULL, welcome_header CLOB DEFAULT NULL, welcome_text CLOB DEFAULT NULL, display_tenant_count_adult INTEGER NOT NULL, display_tenant_count_child INTEGER NOT NULL, display_pet INTEGER NOT NULL, display_play_instrument INTEGER NOT NULL, display_garage INTEGER NOT NULL, display_car_park INTEGER NOT NULL, display_birth_date INTEGER NOT NULL, display_civil_status INTEGER NOT NULL, display_nationality INTEGER NOT NULL, display_residence_authorization INTEGER NOT NULL, display_payment_enforcement INTEGER NOT NULL, display_leasing_contracts INTEGER NOT NULL, display_leasing_rate_per_month INTEGER NOT NULL, display_telephone INTEGER NOT NULL, display_telephone_mobile INTEGER NOT NULL, display_email INTEGER NOT NULL, display_employer INTEGER NOT NULL, display_old_landlord INTEGER NOT NULL, display_relocation_reason INTEGER NOT NULL, display_notice_by INTEGER NOT NULL, display_salary INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_5BE248EF176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO application_slot (id, apartment_id, name, description) SELECT id, apartment_id, name, description FROM __temp__application_slot');
        $this->addSql('DROP TABLE __temp__application_slot');
        $this->addSql('CREATE INDEX IDX_5BE248EF176DFE85 ON application_slot (apartment_id)');
        $this->addSql('DROP INDEX UNIQ_C73586EE7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backend_user AS SELECT id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM backend_user');
        $this->addSql('DROP TABLE backend_user');
        $this->addSql('CREATE TABLE backend_user (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, email CLOB NOT NULL COLLATE BINARY, password_hash CLOB NOT NULL COLLATE BINARY, reset_hash CLOB NOT NULL COLLATE BINARY, is_enabled BOOLEAN NOT NULL, registration_date DATETIME NOT NULL, agb_accepted BOOLEAN DEFAULT \'0\' NOT NULL, can_administer_company BOOLEAN NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_C73586E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO backend_user (id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted) SELECT id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM __temp__backend_user');
        $this->addSql('DROP TABLE __temp__backend_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C73586EE7927C74 ON backend_user (email)');
        $this->addSql('CREATE INDEX IDX_C73586E979B1AD6 ON backend_user (company_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, name, description, street, street_nr, address_line, postal_code, city, country FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, street CLOB DEFAULT NULL COLLATE BINARY, street_nr CLOB DEFAULT NULL COLLATE BINARY, address_line CLOB DEFAULT NULL COLLATE BINARY, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL COLLATE BINARY, country CLOB DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_E16F61D4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO building (id, name, description, street, street_nr, address_line, postal_code, city, country) SELECT id, name, description, street, street_nr, address_line, postal_code, city, country FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('CREATE INDEX IDX_E16F61D4979B1AD6 ON building (company_id)');
        $this->addSql('DROP INDEX IDX_9F74B8987887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__setting AS SELECT id, frontend_user_id, "key", content FROM setting');
        $this->addSql('DROP TABLE setting');
        $this->addSql('CREATE TABLE setting (id INTEGER NOT NULL, frontend_user_id INTEGER DEFAULT NULL, "key" CLOB NOT NULL COLLATE BINARY, content CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_9F74B8987887A021 FOREIGN KEY (frontend_user_id) REFERENCES frontend_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO setting (id, frontend_user_id, "key", content) SELECT id, frontend_user_id, "key", content FROM __temp__setting');
        $this->addSql('DROP TABLE __temp__setting');
        $this->addSql('CREATE INDEX IDX_9F74B8987887A021 ON setting (frontend_user_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE applicant');
        $this->addSql('DROP TABLE applicant_job');
        $this->addSql('DROP TABLE applicant_landlord');
        $this->addSql('DROP TABLE applicant_reference');
        $this->addSql('DROP TABLE company');
        $this->addSql('DROP INDEX IDX_4D7E68544D2A7E12');
        $this->addSql('CREATE TEMPORARY TABLE __temp__apartment AS SELECT id, building_id, name, description FROM apartment');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('CREATE TABLE apartment (id INTEGER NOT NULL, building_id INTEGER DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO apartment (id, building_id, name, description) SELECT id, building_id, name, description FROM __temp__apartment');
        $this->addSql('DROP TABLE __temp__apartment');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application AS SELECT id FROM application');
        $this->addSql('DROP TABLE application');
        $this->addSql('CREATE TABLE application (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO application (id) SELECT id FROM __temp__application');
        $this->addSql('DROP TABLE __temp__application');
        $this->addSql('DROP INDEX IDX_5BE248EF176DFE85');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_slot AS SELECT id, apartment_id, name, description FROM application_slot');
        $this->addSql('DROP TABLE application_slot');
        $this->addSql('CREATE TABLE application_slot (id INTEGER NOT NULL, apartment_id INTEGER DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO application_slot (id, apartment_id, name, description) SELECT id, apartment_id, name, description FROM __temp__application_slot');
        $this->addSql('DROP TABLE __temp__application_slot');
        $this->addSql('CREATE INDEX IDX_5BE248EF176DFE85 ON application_slot (apartment_id)');
        $this->addSql('DROP INDEX UNIQ_C73586EE7927C74');
        $this->addSql('DROP INDEX IDX_C73586E979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backend_user AS SELECT id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM backend_user');
        $this->addSql('DROP TABLE backend_user');
        $this->addSql('CREATE TABLE backend_user (id INTEGER NOT NULL, email CLOB NOT NULL, password_hash CLOB NOT NULL, reset_hash CLOB NOT NULL, is_enabled BOOLEAN NOT NULL, registration_date DATETIME NOT NULL, agb_accepted BOOLEAN DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO backend_user (id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted) SELECT id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM __temp__backend_user');
        $this->addSql('DROP TABLE __temp__backend_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C73586EE7927C74 ON backend_user (email)');
        $this->addSql('DROP INDEX IDX_E16F61D4979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, name, description, street, street_nr, address_line, postal_code, city, country FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER NOT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO building (id, name, description, street, street_nr, address_line, postal_code, city, country) SELECT id, name, description, street, street_nr, address_line, postal_code, city, country FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('DROP INDEX IDX_9F74B8987887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__setting AS SELECT id, frontend_user_id, "key", content FROM setting');
        $this->addSql('DROP TABLE setting');
        $this->addSql('CREATE TABLE setting (id INTEGER NOT NULL, frontend_user_id INTEGER DEFAULT NULL, "key" CLOB NOT NULL, content CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO setting (id, frontend_user_id, "key", content) SELECT id, frontend_user_id, "key", content FROM __temp__setting');
        $this->addSql('DROP TABLE __temp__setting');
        $this->addSql('CREATE INDEX IDX_9F74B8987887A021 ON setting (frontend_user_id)');
    }
}
