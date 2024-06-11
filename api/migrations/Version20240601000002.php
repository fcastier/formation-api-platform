<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601000002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add `email` & `manager` to `Employee`';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employee ADD manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE employee ADD CONSTRAINT FK_5D9F75A1783E3463 FOREIGN KEY (manager_id) REFERENCES employee (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5D9F75A1783E3463 ON employee (manager_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public IF NOT EXISTS public');
        $this->addSql('ALTER TABLE employee DROP CONSTRAINT FK_5D9F75A1783E3463');
        $this->addSql('DROP INDEX IDX_5D9F75A1783E3463');
        $this->addSql('ALTER TABLE employee DROP manager_id');
        $this->addSql('ALTER TABLE employee DROP email');
    }
}
