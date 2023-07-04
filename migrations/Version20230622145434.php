<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230622145434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_certificat DROP FOREIGN KEY FK_D18885D6A76ED395');
        $this->addSql('DROP INDEX IDX_D18885D6A76ED395 ON demande_certificat');
        $this->addSql('ALTER TABLE demande_certificat DROP user_id, DROP statut_demande');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_certificat ADD user_id INT NOT NULL, ADD statut_demande TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE demande_certificat ADD CONSTRAINT FK_D18885D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_D18885D6A76ED395 ON demande_certificat (user_id)');
    }
}
