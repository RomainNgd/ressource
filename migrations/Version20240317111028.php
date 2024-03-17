<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240317111028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, accepted TINYINT(1) NOT NULL, deleted_at DATETIME DEFAULT NULL, ressource_id INT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_9474526CFC6CD52A (ressource_id), INDEX IDX_9474526CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE login_attemps (id INT AUTO_INCREMENT NOT NULL, try_at DATETIME NOT NULL, user_id INT NOT NULL, INDEX IDX_96A589B8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, visible TINYINT(1) NOT NULL, accepted TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, update_at DATETIME DEFAULT NULL, ressource_type_id INT DEFAULT NULL, user_id INT NOT NULL, INDEX IDX_939F454470760271 (ressource_type_id), INDEX IDX_939F4544A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE ressource_type (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE share (id INT AUTO_INCREMENT NOT NULL, shared_at DATETIME NOT NULL, sender_id INT NOT NULL, recipient_id INT NOT NULL, ressource_id INT DEFAULT NULL, INDEX IDX_EF069D5AF624B39D (sender_id), INDEX IDX_EF069D5AE92F8F78 (recipient_id), INDEX IDX_EF069D5AFC6CD52A (ressource_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CFC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE login_attemps ADD CONSTRAINT FK_96A589B8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F454470760271 FOREIGN KEY (ressource_type_id) REFERENCES ressource_type (id)');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5AF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5AE92F8F78 FOREIGN KEY (recipient_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE share ADD CONSTRAINT FK_EF069D5AFC6CD52A FOREIGN KEY (ressource_id) REFERENCES ressource (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CFC6CD52A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE login_attemps DROP FOREIGN KEY FK_96A589B8A76ED395');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F454470760271');
        $this->addSql('ALTER TABLE ressource DROP FOREIGN KEY FK_939F4544A76ED395');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5AF624B39D');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5AE92F8F78');
        $this->addSql('ALTER TABLE share DROP FOREIGN KEY FK_EF069D5AFC6CD52A');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE login_attemps');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP TABLE ressource_type');
        $this->addSql('DROP TABLE share');
        $this->addSql('DROP TABLE user');
    }
}
