<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240208111836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ressource_type (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE ressource ADD ressource_type_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F454470760271 FOREIGN KEY (ressource_type_id) REFERENCES ressource_type (id)');
        $this->addSql('CREATE INDEX IDX_939F454470760271 ON ressource (ressource_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE ressource_type');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F454470760271');
        $this->addSql('DROP INDEX IDX_939F454470760271 ON ressource');
        $this->addSql('ALTER TABLE ressource DROP ressource_type_id');
    }
}
