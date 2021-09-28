<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825075006 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, amount INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD order_line_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1BB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1BB01DC09 ON category (order_line_id)');
        $this->addSql('ALTER TABLE product ADD order_line_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBB01DC09 ON product (order_line_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1BB01DC09');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBB01DC09');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP INDEX IDX_64C19C1BB01DC09 ON category');
        $this->addSql('ALTER TABLE category DROP order_line_id');
        $this->addSql('DROP INDEX IDX_D34A04ADBB01DC09 ON product');
        $this->addSql('ALTER TABLE product DROP order_line_id');
    }
}
