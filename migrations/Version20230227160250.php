<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227160250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_user_response DROP FOREIGN KEY FK_F44F3DEA1E27F6BF');
        $this->addSql('ALTER TABLE quiz_user_response DROP FOREIGN KEY FK_F44F3DEAB5347E35');
        $this->addSql('DROP TABLE quiz_user_response');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz_user_response (id INT AUTO_INCREMENT NOT NULL, quiz_user_id INT DEFAULT NULL, question_id INT DEFAULT NULL, is_valid TINYINT(1) DEFAULT NULL, date_see VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, date_answer VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F44F3DEAB5347E35 (quiz_user_id), INDEX IDX_F44F3DEA1E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE quiz_user_response ADD CONSTRAINT FK_F44F3DEA1E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE quiz_user_response ADD CONSTRAINT FK_F44F3DEAB5347E35 FOREIGN KEY (quiz_user_id) REFERENCES quiz_user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
