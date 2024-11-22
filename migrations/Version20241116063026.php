<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241116063026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depositary ADD portfolio_id INT NOT NULL');
        $this->addSql('ALTER TABLE depositary ADD CONSTRAINT FK_7CD08B68B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolio (id)');
        $this->addSql('CREATE INDEX IDX_7CD08B68B96B5643 ON depositary (portfolio_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depositary DROP FOREIGN KEY FK_7CD08B68B96B5643');
        $this->addSql('DROP INDEX IDX_7CD08B68B96B5643 ON depositary');
        $this->addSql('ALTER TABLE depositary DROP portfolio_id');
    }
}
