<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426084459 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO proposer (hotel_id,categorie_id,tarif_nuite) VALUES (1,1,50)');
        $this->addSql('INSERT INTO proposer (hotel_id,categorie_id,tarif_nuite) VALUES (1,2,55)');
        $this->addSql('INSERT INTO proposer (hotel_id,categorie_id,tarif_nuite) VALUES (2,1,45)');
        $this->addSql('INSERT INTO proposer (hotel_id,categorie_id,tarif_nuite) VALUES (2,2,50)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE proposer');
    }
}
