<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410171131 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE achat_user (achat_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_10A9589EFE95D117 (achat_id), INDEX IDX_10A9589EA76ED395 (user_id), PRIMARY KEY(achat_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE achat_cours (achat_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_E5E0F165FE95D117 (achat_id), INDEX IDX_E5E0F1657ECF78B0 (cours_id), PRIMARY KEY(achat_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat_user ADD CONSTRAINT FK_10A9589EFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE achat_user ADD CONSTRAINT FK_10A9589EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE achat_cours ADD CONSTRAINT FK_E5E0F165FE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE achat_cours ADD CONSTRAINT FK_E5E0F1657ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE achat_user DROP FOREIGN KEY FK_10A9589EFE95D117');
        $this->addSql('ALTER TABLE achat_cours DROP FOREIGN KEY FK_E5E0F165FE95D117');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE achat_user');
        $this->addSql('DROP TABLE achat_cours');
    }
}
