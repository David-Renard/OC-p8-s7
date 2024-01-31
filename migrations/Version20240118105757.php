<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118105757 extends AbstractMigration
{


    public function getDescription(): string
    {
        return '';

    }


    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE task ALTER author_id DROP NOT NULL');

    }


    public function down(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task ALTER author_id SET NOT NULL');

    }


}
