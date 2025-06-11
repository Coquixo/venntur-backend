<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250611215616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE actividad ADD proveedor_id INT DEFAULT NULL, ADD nombre VARCHAR(255) NOT NULL, ADD descripcion_corta VARCHAR(255) NOT NULL, ADD descripcion_larga LONGTEXT NOT NULL, ADD precio DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE actividad ADD CONSTRAINT FK_8DF2BD06CB305D73 FOREIGN KEY (proveedor_id) REFERENCES proveedor (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8DF2BD06CB305D73 ON actividad (proveedor_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proveedor ADD nombre VARCHAR(255) NOT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE actividad DROP FOREIGN KEY FK_8DF2BD06CB305D73
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_8DF2BD06CB305D73 ON actividad
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE actividad DROP proveedor_id, DROP nombre, DROP descripcion_corta, DROP descripcion_larga, DROP precio
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE proveedor DROP nombre
        SQL);
    }
}
