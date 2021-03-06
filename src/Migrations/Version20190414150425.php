<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190414150425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, restaurant_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_5F9E962AA76ED395 (user_id), INDEX IDX_5F9E962AB1E7706E (restaurant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_notes (restaurant_id INT NOT NULL, notes_id INT NOT NULL, INDEX IDX_4B06155DB1E7706E (restaurant_id), INDEX IDX_4B06155DFC56F556 (notes_id), PRIMARY KEY(restaurant_id, notes_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes (id INT AUTO_INCREMENT NOT NULL, note VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('ALTER TABLE restaurant_notes ADD CONSTRAINT FK_4B06155DB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_notes ADD CONSTRAINT FK_4B06155DFC56F556 FOREIGN KEY (notes_id) REFERENCES notes (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE restaurant_notes DROP FOREIGN KEY FK_4B06155DFC56F556');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE restaurant_notes');
        $this->addSql('DROP TABLE notes');
    }
}
