<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220823181318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pdv (id INT AUTO_INCREMENT NOT NULL, pdv_id INT NOT NULL, latitude VARCHAR(255) NOT NULL, longitude VARCHAR(255) NOT NULL, datas LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', postalcode VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pdv_log (id INT AUTO_INCREMENT NOT NULL, pdv_id INT DEFAULT NULL, datas LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_77E3F9551069E8D (pdv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pdv_log ADD CONSTRAINT FK_77E3F9551069E8D FOREIGN KEY (pdv_id) REFERENCES pdv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdv_log DROP FOREIGN KEY FK_77E3F9551069E8D');
        $this->addSql('DROP TABLE pdv');
        $this->addSql('DROP TABLE pdv_log');
    }
}
