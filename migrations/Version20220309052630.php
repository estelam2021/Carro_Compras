<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309052630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAA842875F2');
        $this->addSql('ALTER TABLE pedidos DROP FOREIGN KEY FK_6716CCAAD05AC01D');
        $this->addSql('DROP INDEX IDX_6716CCAA842875F2 ON pedidos');
        $this->addSql('DROP INDEX IDX_6716CCAAD05AC01D ON pedidos');
        $this->addSql('ALTER TABLE pedidos ADD talla_pedido INT NOT NULL, ADD color_pedido INT NOT NULL, DROP talla_pedido_id, DROP color_pedido_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pedidos ADD talla_pedido_id INT NOT NULL, ADD color_pedido_id INT NOT NULL, DROP talla_pedido, DROP color_pedido');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAA842875F2 FOREIGN KEY (talla_pedido_id) REFERENCES tallas (id)');
        $this->addSql('ALTER TABLE pedidos ADD CONSTRAINT FK_6716CCAAD05AC01D FOREIGN KEY (color_pedido_id) REFERENCES color (id)');
        $this->addSql('CREATE INDEX IDX_6716CCAA842875F2 ON pedidos (talla_pedido_id)');
        $this->addSql('CREATE INDEX IDX_6716CCAAD05AC01D ON pedidos (color_pedido_id)');
    }
}
