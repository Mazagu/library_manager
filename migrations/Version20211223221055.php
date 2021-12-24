<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211223221055 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE book (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, copies INTEGER NOT NULL, genres VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE loan (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, book_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, id_card VARCHAR(255) NOT NULL, phone_number VARCHAR(255) NOT NULL, loan_date DATETIME NOT NULL, return_date DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_C5D30D0316A2B381 ON loan (book_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE loan');
    }
}
