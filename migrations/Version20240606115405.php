<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240606115405 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hobby (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(70) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE job CHANGE designation designation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176BE04EA9');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_34DCD176CCFA12B8 ON person');
        $this->addSql('DROP INDEX IDX_34DCD176BE04EA9 ON person');
        $this->addSql('ALTER TABLE person DROP profile_id, DROP job_id, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE profile ADD rs VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE hobby');
        $this->addSql('ALTER TABLE job CHANGE designation designation VARCHAR(70) NOT NULL');
        $this->addSql('ALTER TABLE person ADD profile_id INT DEFAULT NULL, ADD job_id INT DEFAULT NULL, ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_34DCD176CCFA12B8 ON person (profile_id)');
        $this->addSql('CREATE INDEX IDX_34DCD176BE04EA9 ON person (job_id)');
        $this->addSql('ALTER TABLE profile DROP rs');
    }
}
