<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240516084712 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_audioguide (user_id INT NOT NULL, audioguide_id INT NOT NULL, INDEX IDX_7F6D6D9EA76ED395 (user_id), INDEX IDX_7F6D6D9E9C12F5EA (audioguide_id), PRIMARY KEY(user_id, audioguide_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_audioguide ADD CONSTRAINT FK_7F6D6D9EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_audioguide ADD CONSTRAINT FK_7F6D6D9E9C12F5EA FOREIGN KEY (audioguide_id) REFERENCES audioguide (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_audioguide DROP FOREIGN KEY FK_7F6D6D9EA76ED395');
        $this->addSql('ALTER TABLE user_audioguide DROP FOREIGN KEY FK_7F6D6D9E9C12F5EA');
        $this->addSql('DROP TABLE user_audioguide');
    }
}
