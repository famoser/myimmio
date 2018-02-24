<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180224195211 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_E79CAB6D1645DEA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_job AS SELECT id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at FROM applicant_job');
        $this->addSql('DROP TABLE applicant_job');
        $this->addSql('CREATE TABLE applicant_job (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, profession CLOB DEFAULT NULL COLLATE BINARY, yearly_salary INTEGER DEFAULT NULL, working_since DATE DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_E79CAB6D1645DEA9 FOREIGN KEY (reference_id) REFERENCES applicant_reference (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO applicant_job (id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at) SELECT id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at FROM __temp__applicant_job');
        $this->addSql('DROP TABLE __temp__applicant_job');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E79CAB6D1645DEA9 ON applicant_job (reference_id)');
        $this->addSql('DROP INDEX IDX_523B2A03B25B14AF');
        $this->addSql('DROP INDEX IDX_523B2A037887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_preview AS SELECT id, application_slot_id, frontend_user_id, created_at, last_changed_at FROM application_preview');
        $this->addSql('DROP TABLE application_preview');
        $this->addSql('CREATE TABLE application_preview (id INTEGER NOT NULL, application_slot_id INTEGER DEFAULT NULL, frontend_user_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_523B2A03B25B14AF FOREIGN KEY (application_slot_id) REFERENCES application_slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_523B2A037887A021 FOREIGN KEY (frontend_user_id) REFERENCES frontend_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO application_preview (id, application_slot_id, frontend_user_id, created_at, last_changed_at) SELECT id, application_slot_id, frontend_user_id, created_at, last_changed_at FROM __temp__application_preview');
        $this->addSql('DROP TABLE __temp__application_preview');
        $this->addSql('CREATE INDEX IDX_523B2A03B25B14AF ON application_preview (application_slot_id)');
        $this->addSql('CREATE INDEX IDX_523B2A037887A021 ON application_preview (frontend_user_id)');
        $this->addSql('ALTER TABLE frontend_user ADD COLUMN given_name CLOB DEFAULT NULL');
        $this->addSql('ALTER TABLE frontend_user ADD COLUMN family_name CLOB DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_4D7E68544D2A7E12');
        $this->addSql('CREATE TEMPORARY TABLE __temp__apartment AS SELECT id, building_id, name, description, created_at, last_changed_at FROM apartment');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('CREATE TABLE apartment (id INTEGER NOT NULL, building_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_4D7E68544D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO apartment (id, building_id, name, description, created_at, last_changed_at) SELECT id, building_id, name, description, created_at, last_changed_at FROM __temp__apartment');
        $this->addSql('DROP TABLE __temp__apartment');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('DROP INDEX IDX_E16F61D4979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, company_id, name, description, street, street_nr, address_line, postal_code, city, country, created_at, last_changed_at FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, street CLOB DEFAULT NULL COLLATE BINARY, street_nr CLOB DEFAULT NULL COLLATE BINARY, address_line CLOB DEFAULT NULL COLLATE BINARY, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL COLLATE BINARY, country CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_E16F61D4979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO building (id, company_id, name, description, street, street_nr, address_line, postal_code, city, country, created_at, last_changed_at) SELECT id, company_id, name, description, street, street_nr, address_line, postal_code, city, country, created_at, last_changed_at FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('CREATE INDEX IDX_E16F61D4979B1AD6 ON building (company_id)');
        $this->addSql('DROP INDEX IDX_978A66E19F66D4CC');
        $this->addSql('DROP INDEX IDX_978A66E14D2A7E12');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building_backend_user AS SELECT building_id, backend_user_id FROM building_backend_user');
        $this->addSql('DROP TABLE building_backend_user');
        $this->addSql('CREATE TABLE building_backend_user (building_id INTEGER NOT NULL, backend_user_id INTEGER NOT NULL, PRIMARY KEY(building_id, backend_user_id), CONSTRAINT FK_978A66E14D2A7E12 FOREIGN KEY (building_id) REFERENCES building (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_978A66E19F66D4CC FOREIGN KEY (backend_user_id) REFERENCES backend_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO building_backend_user (building_id, backend_user_id) SELECT building_id, backend_user_id FROM __temp__building_backend_user');
        $this->addSql('DROP TABLE __temp__building_backend_user');
        $this->addSql('CREATE INDEX IDX_978A66E19F66D4CC ON building_backend_user (backend_user_id)');
        $this->addSql('CREATE INDEX IDX_978A66E14D2A7E12 ON building_backend_user (building_id)');
        $this->addSql('DROP INDEX IDX_5BE248EF176DFE85');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_slot AS SELECT id, apartment_id, name, description, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_relocation_reason, display_notice_by, display_current_landlord, display_yearly_salary, created_at, last_changed_at FROM application_slot');
        $this->addSql('DROP TABLE application_slot');
        $this->addSql('CREATE TABLE application_slot (id INTEGER NOT NULL, apartment_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, identifier CLOB DEFAULT NULL COLLATE BINARY, welcome_header CLOB DEFAULT NULL COLLATE BINARY, welcome_text CLOB DEFAULT NULL COLLATE BINARY, display_tenant_count_child INTEGER NOT NULL, display_pet INTEGER NOT NULL, display_play_instrument INTEGER NOT NULL, display_birth_date INTEGER NOT NULL, display_civil_status INTEGER NOT NULL, display_nationality INTEGER NOT NULL, display_residence_authorization INTEGER NOT NULL, display_telephone INTEGER NOT NULL, display_telephone_mobile INTEGER NOT NULL, display_email INTEGER NOT NULL, display_employer INTEGER NOT NULL, display_relocation_reason INTEGER NOT NULL, display_notice_by INTEGER NOT NULL, display_current_landlord INTEGER NOT NULL, display_yearly_salary INTEGER NOT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_5BE248EF176DFE85 FOREIGN KEY (apartment_id) REFERENCES apartment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO application_slot (id, apartment_id, name, description, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_relocation_reason, display_notice_by, display_current_landlord, display_yearly_salary, created_at, last_changed_at) SELECT id, apartment_id, name, description, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_relocation_reason, display_notice_by, display_current_landlord, display_yearly_salary, created_at, last_changed_at FROM __temp__application_slot');
        $this->addSql('DROP TABLE __temp__application_slot');
        $this->addSql('CREATE INDEX IDX_5BE248EF176DFE85 ON application_slot (apartment_id)');
        $this->addSql('DROP INDEX UNIQ_CAAD1019920427E9');
        $this->addSql('DROP INDEX IDX_CAAD10193E030ACD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant AS SELECT id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, current_landlord, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, email, residence_authorization, telephone_mobile, created_at, last_changed_at FROM applicant');
        $this->addSql('DROP TABLE applicant');
        $this->addSql('CREATE TABLE applicant (id INTEGER NOT NULL, applicant_job_id INTEGER DEFAULT NULL, application_id INTEGER DEFAULT NULL, salutation CLOB DEFAULT NULL COLLATE BINARY, birth_date DATE DEFAULT NULL, civil_status CLOB DEFAULT NULL COLLATE BINARY, nationality CLOB DEFAULT NULL COLLATE BINARY, current_landlord CLOB DEFAULT NULL COLLATE BINARY, street CLOB DEFAULT NULL COLLATE BINARY, street_nr CLOB DEFAULT NULL COLLATE BINARY, address_line CLOB DEFAULT NULL COLLATE BINARY, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL COLLATE BINARY, country CLOB DEFAULT NULL COLLATE BINARY, telephone CLOB DEFAULT NULL COLLATE BINARY, email CLOB NOT NULL COLLATE BINARY, residence_authorization CLOB DEFAULT NULL COLLATE BINARY, telephone_mobile CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, given_name CLOB DEFAULT NULL, family_name CLOB DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_CAAD1019920427E9 FOREIGN KEY (applicant_job_id) REFERENCES applicant_job (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CAAD10193E030ACD FOREIGN KEY (application_id) REFERENCES application (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO applicant (id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, current_landlord, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, email, residence_authorization, telephone_mobile, created_at, last_changed_at) SELECT id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, current_landlord, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, email, residence_authorization, telephone_mobile, created_at, last_changed_at FROM __temp__applicant');
        $this->addSql('DROP TABLE __temp__applicant');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAAD1019920427E9 ON applicant (applicant_job_id)');
        $this->addSql('CREATE INDEX IDX_CAAD10193E030ACD ON applicant (application_id)');
        $this->addSql('DROP INDEX IDX_A45BDDC17887A021');
        $this->addSql('DROP INDEX IDX_A45BDDC1B25B14AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application AS SELECT id, application_slot_id, frontend_user_id, pets, instruments, tenant_count_child, created_at, last_changed_at FROM application');
        $this->addSql('DROP TABLE application');
        $this->addSql('CREATE TABLE application (id INTEGER NOT NULL, application_slot_id INTEGER DEFAULT NULL, frontend_user_id INTEGER DEFAULT NULL, pets CLOB DEFAULT NULL COLLATE BINARY, instruments CLOB DEFAULT NULL COLLATE BINARY, tenant_count_child INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_A45BDDC1B25B14AF FOREIGN KEY (application_slot_id) REFERENCES application_slot (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_A45BDDC17887A021 FOREIGN KEY (frontend_user_id) REFERENCES frontend_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO application (id, application_slot_id, frontend_user_id, pets, instruments, tenant_count_child, created_at, last_changed_at) SELECT id, application_slot_id, frontend_user_id, pets, instruments, tenant_count_child, created_at, last_changed_at FROM __temp__application');
        $this->addSql('DROP TABLE __temp__application');
        $this->addSql('CREATE INDEX IDX_A45BDDC17887A021 ON application (frontend_user_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC1B25B14AF ON application (application_slot_id)');
        $this->addSql('DROP INDEX UNIQ_C73586EE7927C74');
        $this->addSql('DROP INDEX IDX_C73586E979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backend_user AS SELECT id, company_id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, can_administer_company, created_at, last_changed_at FROM backend_user');
        $this->addSql('DROP TABLE backend_user');
        $this->addSql('CREATE TABLE backend_user (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, email CLOB NOT NULL COLLATE BINARY, password_hash CLOB NOT NULL COLLATE BINARY, reset_hash CLOB NOT NULL COLLATE BINARY, is_enabled BOOLEAN NOT NULL, registration_date DATETIME NOT NULL, agb_accepted BOOLEAN DEFAULT \'0\' NOT NULL, can_administer_company BOOLEAN NOT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_C73586E979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO backend_user (id, company_id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, can_administer_company, created_at, last_changed_at) SELECT id, company_id, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, can_administer_company, created_at, last_changed_at FROM __temp__backend_user');
        $this->addSql('DROP TABLE __temp__backend_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C73586EE7927C74 ON backend_user (email)');
        $this->addSql('CREATE INDEX IDX_C73586E979B1AD6 ON backend_user (company_id)');
        $this->addSql('DROP INDEX UNIQ_3051E7E51645DEA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_landlord AS SELECT id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at FROM applicant_landlord');
        $this->addSql('DROP TABLE applicant_landlord');
        $this->addSql('CREATE TABLE applicant_landlord (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, relocation_reason CLOB DEFAULT NULL COLLATE BINARY, renting_since DATE DEFAULT NULL, notice_by CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_3051E7E51645DEA9 FOREIGN KEY (reference_id) REFERENCES applicant_reference (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO applicant_landlord (id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at) SELECT id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at FROM __temp__applicant_landlord');
        $this->addSql('DROP TABLE __temp__applicant_landlord');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3051E7E51645DEA9 ON applicant_landlord (reference_id)');
        $this->addSql('DROP INDEX IDX_CD6132C597139001');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_reference AS SELECT id, applicant_id, name, description, given_name, family_name, telephone, email, telephone_mobile, created_at, last_changed_at FROM applicant_reference');
        $this->addSql('DROP TABLE applicant_reference');
        $this->addSql('CREATE TABLE applicant_reference (id INTEGER NOT NULL, applicant_id INTEGER DEFAULT NULL, name CLOB NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, telephone CLOB DEFAULT NULL COLLATE BINARY, email CLOB NOT NULL COLLATE BINARY, telephone_mobile CLOB DEFAULT NULL COLLATE BINARY, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, given_name CLOB DEFAULT NULL, family_name CLOB DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_CD6132C597139001 FOREIGN KEY (applicant_id) REFERENCES applicant (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO applicant_reference (id, applicant_id, name, description, given_name, family_name, telephone, email, telephone_mobile, created_at, last_changed_at) SELECT id, applicant_id, name, description, given_name, family_name, telephone, email, telephone_mobile, created_at, last_changed_at FROM __temp__applicant_reference');
        $this->addSql('DROP TABLE __temp__applicant_reference');
        $this->addSql('CREATE INDEX IDX_CD6132C597139001 ON applicant_reference (applicant_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4D7E68544D2A7E12');
        $this->addSql('CREATE TEMPORARY TABLE __temp__apartment AS SELECT id, building_id, created_at, last_changed_at, name, description FROM apartment');
        $this->addSql('DROP TABLE apartment');
        $this->addSql('CREATE TABLE apartment (id INTEGER NOT NULL, building_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO apartment (id, building_id, created_at, last_changed_at, name, description) SELECT id, building_id, created_at, last_changed_at, name, description FROM __temp__apartment');
        $this->addSql('DROP TABLE __temp__apartment');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('DROP INDEX UNIQ_CAAD1019920427E9');
        $this->addSql('DROP INDEX IDX_CAAD10193E030ACD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant AS SELECT id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, residence_authorization, current_landlord, created_at, last_changed_at, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, telephone_mobile, email FROM applicant');
        $this->addSql('DROP TABLE applicant');
        $this->addSql('CREATE TABLE applicant (id INTEGER NOT NULL, applicant_job_id INTEGER DEFAULT NULL, application_id INTEGER DEFAULT NULL, salutation CLOB DEFAULT NULL, birth_date DATE DEFAULT NULL, civil_status CLOB DEFAULT NULL, nationality CLOB DEFAULT NULL, residence_authorization CLOB DEFAULT NULL, current_landlord CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, telephone CLOB DEFAULT NULL, telephone_mobile CLOB DEFAULT NULL, email CLOB NOT NULL, given_name CLOB NOT NULL COLLATE BINARY, family_name CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO applicant (id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, residence_authorization, current_landlord, created_at, last_changed_at, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, telephone_mobile, email) SELECT id, applicant_job_id, application_id, salutation, birth_date, civil_status, nationality, residence_authorization, current_landlord, created_at, last_changed_at, given_name, family_name, street, street_nr, address_line, postal_code, city, country, telephone, telephone_mobile, email FROM __temp__applicant');
        $this->addSql('DROP TABLE __temp__applicant');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CAAD1019920427E9 ON applicant (applicant_job_id)');
        $this->addSql('CREATE INDEX IDX_CAAD10193E030ACD ON applicant (application_id)');
        $this->addSql('DROP INDEX UNIQ_E79CAB6D1645DEA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_job AS SELECT id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at FROM applicant_job');
        $this->addSql('DROP TABLE applicant_job');
        $this->addSql('CREATE TABLE applicant_job (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, profession CLOB DEFAULT NULL, yearly_salary INTEGER DEFAULT NULL, working_since DATE DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO applicant_job (id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at) SELECT id, reference_id, profession, yearly_salary, working_since, created_at, last_changed_at FROM __temp__applicant_job');
        $this->addSql('DROP TABLE __temp__applicant_job');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E79CAB6D1645DEA9 ON applicant_job (reference_id)');
        $this->addSql('DROP INDEX UNIQ_3051E7E51645DEA9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_landlord AS SELECT id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at FROM applicant_landlord');
        $this->addSql('DROP TABLE applicant_landlord');
        $this->addSql('CREATE TABLE applicant_landlord (id INTEGER NOT NULL, reference_id INTEGER DEFAULT NULL, relocation_reason CLOB DEFAULT NULL, renting_since DATE DEFAULT NULL, notice_by CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO applicant_landlord (id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at) SELECT id, reference_id, relocation_reason, renting_since, notice_by, created_at, last_changed_at FROM __temp__applicant_landlord');
        $this->addSql('DROP TABLE __temp__applicant_landlord');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3051E7E51645DEA9 ON applicant_landlord (reference_id)');
        $this->addSql('DROP INDEX IDX_CD6132C597139001');
        $this->addSql('CREATE TEMPORARY TABLE __temp__applicant_reference AS SELECT id, applicant_id, created_at, last_changed_at, name, description, given_name, family_name, telephone, telephone_mobile, email FROM applicant_reference');
        $this->addSql('DROP TABLE applicant_reference');
        $this->addSql('CREATE TABLE applicant_reference (id INTEGER NOT NULL, applicant_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, telephone CLOB DEFAULT NULL, telephone_mobile CLOB DEFAULT NULL, email CLOB NOT NULL, given_name CLOB NOT NULL COLLATE BINARY, family_name CLOB NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO applicant_reference (id, applicant_id, created_at, last_changed_at, name, description, given_name, family_name, telephone, telephone_mobile, email) SELECT id, applicant_id, created_at, last_changed_at, name, description, given_name, family_name, telephone, telephone_mobile, email FROM __temp__applicant_reference');
        $this->addSql('DROP TABLE __temp__applicant_reference');
        $this->addSql('CREATE INDEX IDX_CD6132C597139001 ON applicant_reference (applicant_id)');
        $this->addSql('DROP INDEX IDX_A45BDDC1B25B14AF');
        $this->addSql('DROP INDEX IDX_A45BDDC17887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application AS SELECT id, application_slot_id, frontend_user_id, tenant_count_child, pets, instruments, created_at, last_changed_at FROM application');
        $this->addSql('DROP TABLE application');
        $this->addSql('CREATE TABLE application (id INTEGER NOT NULL, application_slot_id INTEGER DEFAULT NULL, frontend_user_id INTEGER DEFAULT NULL, tenant_count_child INTEGER DEFAULT NULL, pets CLOB DEFAULT NULL, instruments CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO application (id, application_slot_id, frontend_user_id, tenant_count_child, pets, instruments, created_at, last_changed_at) SELECT id, application_slot_id, frontend_user_id, tenant_count_child, pets, instruments, created_at, last_changed_at FROM __temp__application');
        $this->addSql('DROP TABLE __temp__application');
        $this->addSql('CREATE INDEX IDX_A45BDDC1B25B14AF ON application (application_slot_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC17887A021 ON application (frontend_user_id)');
        $this->addSql('DROP INDEX IDX_523B2A03B25B14AF');
        $this->addSql('DROP INDEX IDX_523B2A037887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_preview AS SELECT id, application_slot_id, frontend_user_id, created_at, last_changed_at FROM application_preview');
        $this->addSql('DROP TABLE application_preview');
        $this->addSql('CREATE TABLE application_preview (id INTEGER NOT NULL, application_slot_id INTEGER DEFAULT NULL, frontend_user_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO application_preview (id, application_slot_id, frontend_user_id, created_at, last_changed_at) SELECT id, application_slot_id, frontend_user_id, created_at, last_changed_at FROM __temp__application_preview');
        $this->addSql('DROP TABLE __temp__application_preview');
        $this->addSql('CREATE INDEX IDX_523B2A03B25B14AF ON application_preview (application_slot_id)');
        $this->addSql('CREATE INDEX IDX_523B2A037887A021 ON application_preview (frontend_user_id)');
        $this->addSql('DROP INDEX IDX_5BE248EF176DFE85');
        $this->addSql('CREATE TEMPORARY TABLE __temp__application_slot AS SELECT id, apartment_id, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_current_landlord, display_relocation_reason, display_notice_by, display_yearly_salary, created_at, last_changed_at, name, description FROM application_slot');
        $this->addSql('DROP TABLE application_slot');
        $this->addSql('CREATE TABLE application_slot (id INTEGER NOT NULL, apartment_id INTEGER DEFAULT NULL, start_at DATETIME DEFAULT NULL, end_at DATETIME DEFAULT NULL, identifier CLOB DEFAULT NULL, welcome_header CLOB DEFAULT NULL, welcome_text CLOB DEFAULT NULL, display_tenant_count_child INTEGER NOT NULL, display_pet INTEGER NOT NULL, display_play_instrument INTEGER NOT NULL, display_birth_date INTEGER NOT NULL, display_civil_status INTEGER NOT NULL, display_nationality INTEGER NOT NULL, display_residence_authorization INTEGER NOT NULL, display_telephone INTEGER NOT NULL, display_telephone_mobile INTEGER NOT NULL, display_email INTEGER NOT NULL, display_employer INTEGER NOT NULL, display_current_landlord INTEGER NOT NULL, display_relocation_reason INTEGER NOT NULL, display_notice_by INTEGER NOT NULL, display_yearly_salary INTEGER NOT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO application_slot (id, apartment_id, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_current_landlord, display_relocation_reason, display_notice_by, display_yearly_salary, created_at, last_changed_at, name, description) SELECT id, apartment_id, start_at, end_at, identifier, welcome_header, welcome_text, display_tenant_count_child, display_pet, display_play_instrument, display_birth_date, display_civil_status, display_nationality, display_residence_authorization, display_telephone, display_telephone_mobile, display_email, display_employer, display_current_landlord, display_relocation_reason, display_notice_by, display_yearly_salary, created_at, last_changed_at, name, description FROM __temp__application_slot');
        $this->addSql('DROP TABLE __temp__application_slot');
        $this->addSql('CREATE INDEX IDX_5BE248EF176DFE85 ON application_slot (apartment_id)');
        $this->addSql('DROP INDEX UNIQ_C73586EE7927C74');
        $this->addSql('DROP INDEX IDX_C73586E979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__backend_user AS SELECT id, company_id, can_administer_company, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM backend_user');
        $this->addSql('DROP TABLE backend_user');
        $this->addSql('CREATE TABLE backend_user (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, can_administer_company BOOLEAN NOT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, email CLOB NOT NULL, password_hash CLOB NOT NULL, reset_hash CLOB NOT NULL, is_enabled BOOLEAN NOT NULL, registration_date DATETIME NOT NULL, agb_accepted BOOLEAN DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO backend_user (id, company_id, can_administer_company, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted) SELECT id, company_id, can_administer_company, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted FROM __temp__backend_user');
        $this->addSql('DROP TABLE __temp__backend_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C73586EE7927C74 ON backend_user (email)');
        $this->addSql('CREATE INDEX IDX_C73586E979B1AD6 ON backend_user (company_id)');
        $this->addSql('DROP INDEX IDX_E16F61D4979B1AD6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building AS SELECT id, company_id, created_at, last_changed_at, name, description, street, street_nr, address_line, postal_code, city, country FROM building');
        $this->addSql('DROP TABLE building');
        $this->addSql('CREATE TABLE building (id INTEGER NOT NULL, company_id INTEGER DEFAULT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO building (id, company_id, created_at, last_changed_at, name, description, street, street_nr, address_line, postal_code, city, country) SELECT id, company_id, created_at, last_changed_at, name, description, street, street_nr, address_line, postal_code, city, country FROM __temp__building');
        $this->addSql('DROP TABLE __temp__building');
        $this->addSql('CREATE INDEX IDX_E16F61D4979B1AD6 ON building (company_id)');
        $this->addSql('DROP INDEX IDX_978A66E14D2A7E12');
        $this->addSql('DROP INDEX IDX_978A66E19F66D4CC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__building_backend_user AS SELECT building_id, backend_user_id FROM building_backend_user');
        $this->addSql('DROP TABLE building_backend_user');
        $this->addSql('CREATE TABLE building_backend_user (building_id INTEGER NOT NULL, backend_user_id INTEGER NOT NULL, PRIMARY KEY(building_id, backend_user_id))');
        $this->addSql('INSERT INTO building_backend_user (building_id, backend_user_id) SELECT building_id, backend_user_id FROM __temp__building_backend_user');
        $this->addSql('DROP TABLE __temp__building_backend_user');
        $this->addSql('CREATE INDEX IDX_978A66E14D2A7E12 ON building_backend_user (building_id)');
        $this->addSql('CREATE INDEX IDX_978A66E19F66D4CC ON building_backend_user (backend_user_id)');
        $this->addSql('DROP INDEX UNIQ_E2D1DEAE7927C74');
        $this->addSql('CREATE TEMPORARY TABLE __temp__frontend_user AS SELECT id, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, street, street_nr, address_line, postal_code, city, country FROM frontend_user');
        $this->addSql('DROP TABLE frontend_user');
        $this->addSql('CREATE TABLE frontend_user (id INTEGER NOT NULL, created_at DATETIME DEFAULT NULL, last_changed_at DATETIME DEFAULT NULL, email CLOB NOT NULL, password_hash CLOB NOT NULL, reset_hash CLOB NOT NULL, is_enabled BOOLEAN NOT NULL, registration_date DATETIME NOT NULL, agb_accepted BOOLEAN DEFAULT \'0\' NOT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO frontend_user (id, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, street, street_nr, address_line, postal_code, city, country) SELECT id, created_at, last_changed_at, email, password_hash, reset_hash, is_enabled, registration_date, agb_accepted, street, street_nr, address_line, postal_code, city, country FROM __temp__frontend_user');
        $this->addSql('DROP TABLE __temp__frontend_user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E2D1DEAE7927C74 ON frontend_user (email)');
    }
}
