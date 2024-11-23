<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241123091209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE division (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE event (id SERIAL NOT NULL, sport_id INT NOT NULL, division_id INT NOT NULL, country_id INT NOT NULL, region_id INT DEFAULT NULL, place_id INT NOT NULL, ekp_id INT NOT NULL, title VARCHAR(255) NOT NULL, from_date DATE NOT NULL, to_date DATE NOT NULL, amount INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7AC78BCF8 ON event (sport_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA741859289 ON event (division_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7F92F3E70 ON event (country_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA798260155 ON event (region_id)');
        $this->addSql('CREATE INDEX IDX_3BAE0AA7DA6A219 ON event (place_id)');
        $this->addSql('COMMENT ON COLUMN event.from_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN event.to_date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE event_tag (event_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(event_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_1246725071F7E88B ON event_tag (event_id)');
        $this->addSql('CREATE INDEX IDX_12467250BAD26311 ON event_tag (tag_id)');
        $this->addSql('CREATE TABLE place (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE region (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE sport (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tag (id SERIAL NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA741859289 FOREIGN KEY (division_id) REFERENCES division (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA798260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7DA6A219 FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_tag ADD CONSTRAINT FK_1246725071F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE event_tag ADD CONSTRAINT FK_12467250BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7AC78BCF8');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA741859289');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7F92F3E70');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA798260155');
        $this->addSql('ALTER TABLE event DROP CONSTRAINT FK_3BAE0AA7DA6A219');
        $this->addSql('ALTER TABLE event_tag DROP CONSTRAINT FK_1246725071F7E88B');
        $this->addSql('ALTER TABLE event_tag DROP CONSTRAINT FK_12467250BAD26311');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE division');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_tag');
        $this->addSql('DROP TABLE place');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE tag');
    }
}
