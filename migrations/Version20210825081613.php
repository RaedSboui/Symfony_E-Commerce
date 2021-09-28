<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210825081613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1BB01DC09');
        $this->addSql('DROP INDEX IDX_64C19C1BB01DC09 ON category');
        $this->addSql('ALTER TABLE category DROP order_line_id');
        $this->addSql('ALTER TABLE order_line ADD product_id INT NOT NULL, ADD order_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE14584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE18D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE14584665A ON order_line (product_id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE18D9F6D38 ON order_line (order_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADBB01DC09');
        $this->addSql('DROP INDEX IDX_D34A04ADBB01DC09 ON product');
        $this->addSql('ALTER TABLE product DROP order_line_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ADD order_line_id INT NOT NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1BB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('CREATE INDEX IDX_64C19C1BB01DC09 ON category (order_line_id)');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE14584665A');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE18D9F6D38');
        $this->addSql('DROP INDEX IDX_9CE58EE14584665A ON order_line');
        $this->addSql('DROP INDEX IDX_9CE58EE18D9F6D38 ON order_line');
        $this->addSql('ALTER TABLE order_line DROP product_id, DROP order_id');
        $this->addSql('ALTER TABLE product ADD order_line_id INT NOT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADBB01DC09 FOREIGN KEY (order_line_id) REFERENCES order_line (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADBB01DC09 ON product (order_line_id)');
    }
}
