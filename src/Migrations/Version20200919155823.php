<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200919155823 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE whishlist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_2E936C6DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE whishlist_item (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, whishlist_id INT NOT NULL, INDEX IDX_A63EA1C74584665A (product_id), INDEX IDX_A63EA1C786007B38 (whishlist_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE whishlist ADD CONSTRAINT FK_2E936C6DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE whishlist_item ADD CONSTRAINT FK_A63EA1C74584665A FOREIGN KEY (product_id) REFERENCES products (id)');
        $this->addSql('ALTER TABLE whishlist_item ADD CONSTRAINT FK_A63EA1C786007B38 FOREIGN KEY (whishlist_id) REFERENCES whishlist (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE whishlist_item DROP FOREIGN KEY FK_A63EA1C786007B38');
        $this->addSql('DROP TABLE whishlist');
        $this->addSql('DROP TABLE whishlist_item');
    }
}
