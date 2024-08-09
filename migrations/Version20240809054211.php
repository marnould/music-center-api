<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809054211 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (title VARCHAR(255) NOT NULL, created_date TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, id UUID NOT NULL, artist_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_39986E43B7970CF8 ON album (artist_id)');
        $this->addSql('CREATE TABLE artist (name VARCHAR(255) NOT NULL, created_date TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE track (title VARCHAR(255) NOT NULL, created_date TIMESTAMP(6) WITHOUT TIME ZONE NOT NULL, source VARCHAR NOT NULL, source_track_id VARCHAR(255) NOT NULL, id UUID NOT NULL, artist_id UUID DEFAULT NULL, album_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D6E3F8A6B7970CF8 ON track (artist_id)');
        $this->addSql('CREATE INDEX IDX_D6E3F8A61137ABCF ON track (album_id)');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A6B7970CF8 FOREIGN KEY (artist_id) REFERENCES artist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE track ADD CONSTRAINT FK_D6E3F8A61137ABCF FOREIGN KEY (album_id) REFERENCES album (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE album DROP CONSTRAINT FK_39986E43B7970CF8');
        $this->addSql('ALTER TABLE track DROP CONSTRAINT FK_D6E3F8A6B7970CF8');
        $this->addSql('ALTER TABLE track DROP CONSTRAINT FK_D6E3F8A61137ABCF');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE artist');
        $this->addSql('DROP TABLE track');
    }
}
