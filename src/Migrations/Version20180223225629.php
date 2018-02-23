<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180223225629 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE apartment (id INTEGER NOT NULL, building_id INTEGER DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4D7E68544D2A7E12 ON apartment (building_id)');
        $this->addSql('CREATE TABLE application (id INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE application_slot (id INTEGER NOT NULL, apartment_id INTEGER DEFAULT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5BE248EF176DFE85 ON application_slot (apartment_id)');
        $this->addSql('CREATE TABLE building (id INTEGER NOT NULL, name CLOB NOT NULL, description CLOB DEFAULT NULL, street CLOB DEFAULT NULL, street_nr CLOB DEFAULT NULL, address_line CLOB DEFAULT NULL, postal_code INTEGER DEFAULT NULL, city CLOB DEFAULT NULL, country CLOB DEFAULT NULL, PRIMARY KEY(id))');
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

        $this->addSql('DROP TABLE apartment');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE application_slot');
        $this->addSql('DROP TABLE building');
        $this->addSql('DROP INDEX IDX_9F74B8987887A021');
        $this->addSql('CREATE TEMPORARY TABLE __temp__setting AS SELECT id, frontend_user_id, "key", content FROM setting');
        $this->addSql('DROP TABLE setting');
        $this->addSql('CREATE TABLE setting (id INTEGER NOT NULL, frontend_user_id INTEGER DEFAULT NULL, "key" CLOB NOT NULL, content CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO setting (id, frontend_user_id, "key", content) SELECT id, frontend_user_id, "key", content FROM __temp__setting');
        $this->addSql('DROP TABLE __temp__setting');
        $this->addSql('CREATE INDEX IDX_9F74B8987887A021 ON setting (frontend_user_id)');
    }
}
