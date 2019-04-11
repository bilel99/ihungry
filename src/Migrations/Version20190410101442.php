<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190410101442 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE restaurant DROP INDEX UNIQ_EB95123FA73F0036, ADD INDEX IDX_EB95123FA73F0036 (ville_id)');
        $this->addSql('ALTER TABLE restaurant DROP INDEX UNIQ_EB95123FA76ED395, ADD INDEX IDX_EB95123FA76ED395 (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE restaurant DROP INDEX IDX_EB95123FA76ED395, ADD UNIQUE INDEX UNIQ_EB95123FA76ED395 (user_id)');
        $this->addSql('ALTER TABLE restaurant DROP INDEX IDX_EB95123FA73F0036, ADD UNIQUE INDEX UNIQ_EB95123FA73F0036 (ville_id)');
    }
}
