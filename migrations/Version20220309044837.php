<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309044837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA26F4D3B7');
        $this->addSql('DROP INDEX IDX_6716CCAA26F4D3B7 ON pedidos');
        $this->addSql('ALTER TABLE pedidos DROP product_pedido_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos ADD product_pedido_id INT NOT NULL');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA26F4D3B7 FOREIGN KEY (product_pedido_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_6716CCAA26F4D3B7 ON pedidos (product_pedido_id)');
    }
}
