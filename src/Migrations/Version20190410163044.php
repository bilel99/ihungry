<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410163044 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories_restaurant (categories_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_4A1B5237A21214B7 (categories_id), INDEX IDX_4A1B5237B1E7706E (restaurant_id), PRIMARY KEY(categories_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_restaurant ADD CONSTRAINT FK_4A1B5237B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE restaurant_categories');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE restaurant_categories (restaurant_id INT NOT NULL, categories_id INT NOT NULL, INDEX IDX_9FC96659B1E7706E (restaurant_id), INDEX IDX_9FC96659A21214B7 (categories_id), PRIMARY KEY(restaurant_id, categories_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE restaurant_categories ADD CONSTRAINT FK_9FC96659A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_categories ADD CONSTRAINT FK_9FC96659B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE categories_restaurant');
    }
}
