<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426072214 extends AbstractMigration
{

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("Le club et son projet",25)');
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("Le fonctionnement du club",25)');
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("Les outils à disposition et remis aux clubs",25)');
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("Observatoire des métiers de l\'escrime",25)');
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("I.F.F.E",25)');
        $this->addSql('INSERT INTO atelier (libelle,nb_places_maxi) VALUES ("Développement durable",25)');
    
    }

    public function down(Schema $schema): void
    {
        $this->addSql('TRUNCATE TABLE atelier');
    }
}
