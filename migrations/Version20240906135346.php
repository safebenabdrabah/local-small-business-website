<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240906135346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, full_name VARCHAR(255) NOT NULL, profile_pic VARCHAR(255) DEFAULT NULL, relation VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8157AA0FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE small_business (id INT AUTO_INCREMENT NOT NULL, profile_id INT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, phone_number INT NOT NULL, address VARCHAR(255) DEFAULT NULL, facebook_page VARCHAR(255) DEFAULT NULL, instagram_page VARCHAR(255) DEFAULT NULL, INDEX IDX_EC92AAE9CCFA12B8 (profile_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE small_business_category (small_business_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_9C452CB98A9B88F8 (small_business_id), INDEX IDX_9C452CB912469DE2 (category_id), PRIMARY KEY(small_business_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE small_business ADD CONSTRAINT FK_EC92AAE9CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('ALTER TABLE small_business_category ADD CONSTRAINT FK_9C452CB98A9B88F8 FOREIGN KEY (small_business_id) REFERENCES small_business (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE small_business_category ADD CONSTRAINT FK_9C452CB912469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0FA76ED395');
        $this->addSql('ALTER TABLE small_business DROP FOREIGN KEY FK_EC92AAE9CCFA12B8');
        $this->addSql('ALTER TABLE small_business_category DROP FOREIGN KEY FK_9C452CB98A9B88F8');
        $this->addSql('ALTER TABLE small_business_category DROP FOREIGN KEY FK_9C452CB912469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE small_business');
        $this->addSql('DROP TABLE small_business_category');
        $this->addSql('DROP TABLE user');
    }
}
