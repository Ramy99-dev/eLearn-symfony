<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410180504 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat ADD cour_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456B7942F03 FOREIGN KEY (cour_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_26A98456B7942F03 ON achat (cour_id)');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CFE95D117');
        $this->addSql('DROP INDEX IDX_FDCA8C9CFE95D117 ON cours');
        $this->addSql('ALTER TABLE cours DROP achat_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat DROP FOREIGN KEY FK_26A98456B7942F03');
        $this->addSql('DROP INDEX IDX_26A98456B7942F03 ON achat');
        $this->addSql('ALTER TABLE achat DROP cour_id');
        $this->addSql('ALTER TABLE cours ADD achat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CFE95D117 ON cours (achat_id)');
    }
}
