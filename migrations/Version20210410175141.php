<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210410175141 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_26A98456A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE user_cours');
        $this->addSql('ALTER TABLE cours ADD achat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CFE95D117 ON cours (achat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CFE95D117');
        $this->addSql('CREATE TABLE user_cours (user_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_1F0877C4A76ED395 (user_id), INDEX IDX_1F0877C47ECF78B0 (cours_id), PRIMARY KEY(user_id, cours_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C47ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_cours ADD CONSTRAINT FK_1F0877C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP INDEX IDX_FDCA8C9CFE95D117 ON cours');
        $this->addSql('ALTER TABLE cours DROP achat_id');
    }
}
