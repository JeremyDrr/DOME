<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230117040918 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_ad (category_id INT NOT NULL, ad_id INT NOT NULL, INDEX IDX_DA9F17EA12469DE2 (category_id), INDEX IDX_DA9F17EA4F34D596 (ad_id), PRIMARY KEY(category_id, ad_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_ad ADD CONSTRAINT FK_DA9F17EA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_ad ADD CONSTRAINT FK_DA9F17EA4F34D596 FOREIGN KEY (ad_id) REFERENCES ad (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category_ad DROP FOREIGN KEY FK_DA9F17EA12469DE2');
        $this->addSql('ALTER TABLE category_ad DROP FOREIGN KEY FK_DA9F17EA4F34D596');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_ad');
    }
}
