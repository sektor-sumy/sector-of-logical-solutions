<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180411085038 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fos_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_957A647992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_957A6479A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_957A6479C05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_A3D51B1D2C2AC5D3 (translatable_id), UNIQUE INDEX page_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation_reply (id INT AUTO_INCREMENT NOT NULL, conversation_id INT DEFAULT NULL, author VARCHAR(255) NOT NULL, created_at DATE NOT NULL, reply LONGTEXT NOT NULL, INDEX IDX_E97EE5CC9AC0396 (conversation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, slug VARCHAR(255) NOT NULL, homepage TINYINT(1) DEFAULT \'0\' NOT NULL, in_menu TINYINT(1) DEFAULT \'0\' NOT NULL, title VARCHAR(255) NOT NULL, meta_title VARCHAR(255) NOT NULL, meta_description LONGTEXT DEFAULT NULL, meta_keywords LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, removed_at DATETIME DEFAULT NULL, content LONGTEXT DEFAULT NULL, someFieldYouDoNotNeedToTranslate VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_140AB620989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conversation (id INT AUTO_INCREMENT NOT NULL, hash VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, author VARCHAR(255) DEFAULT NULL, created_at DATE NOT NULL, text LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_8A8E26E9D1B862B8 (hash), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE page_translation ADD CONSTRAINT FK_A3D51B1D2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_reply ADD CONSTRAINT FK_E97EE5CC9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE page_translation DROP FOREIGN KEY FK_A3D51B1D2C2AC5D3');
        $this->addSql('ALTER TABLE conversation_reply DROP FOREIGN KEY FK_E97EE5CC9AC0396');
        $this->addSql('DROP TABLE fos_user');
        $this->addSql('DROP TABLE page_translation');
        $this->addSql('DROP TABLE conversation_reply');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE conversation');
    }
}
