<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411135628 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE restaurant_media (restaurant_id INT NOT NULL, media_id INT NOT NULL, INDEX IDX_203112DDB1E7706E (restaurant_id), INDEX IDX_203112DDEA9FDD75 (media_id), PRIMARY KEY(restaurant_id, media_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_tag (restaurant_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_C2E6743FB1E7706E (restaurant_id), INDEX IDX_C2E6743FBAD26311 (tag_id), PRIMARY KEY(restaurant_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_categories (restaurant_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_9FC96659B1E7706E (restaurant_id), INDEX IDX_9FC96659A21214B7 (categories_id), PRIMARY KEY(restaurant_id, categories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE restaurant_media ADD CONSTRAINT FK_203112DDB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_media ADD CONSTRAINT FK_203112DDEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_tag ADD CONSTRAINT FK_C2E6743FB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_tag ADD CONSTRAINT FK_C2E6743FBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_categories ADD CONSTRAINT FK_9FC96659B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_categories ADD CONSTRAINT FK_9FC96659A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant ADD ville_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123FA73F0036 FOREIGN KEY (ville_id) REFERENCES ville (id)');
        $this->addSql('CREATE INDEX IDX_EB95123FA73F0036 ON restaurant (ville_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE restaurant_media');
        $this->addSql('DROP TABLE restaurant_tag');
        $this->addSql('DROP TABLE restaurant_categories');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123FA73F0036');
        $this->addSql('DROP INDEX IDX_EB95123FA73F0036 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP ville_id');
    }
}
