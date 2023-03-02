<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228093201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD id_quiz_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E96F50B47 FOREIGN KEY (id_quiz_user_id) REFERENCES quiz_user (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E96F50B47 ON question (id_quiz_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E96F50B47');
        $this->addSql('DROP INDEX IDX_B6F7494E96F50B47 ON question');
        $this->addSql('ALTER TABLE question DROP id_quiz_user_id');
    }
}
