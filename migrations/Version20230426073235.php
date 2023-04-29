<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426073235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Diagnostic et identification des critères du club")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Analyse systémique de l\'environnement et méthodologie de mise en oeuvre du projet")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Actions solidaires et innovantes")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Financements")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Outils et documentation")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Valoriser et communiquer sur le projet")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Création - Obligations légales")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Gestion du personnel, de la structure et des conflits")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Relations internes, externes et avec le comité départemental, la ligue et la fédération")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Conventions")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Partenariats")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Logiciel FFE de gestion des compétitions (présentation et formation)")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Présentation du document L\'arbitre en images")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Plaquette guide projet du club ")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Labellisation du club")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Aménagement des équipements")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Assurances")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Observations et analyses sur l\'encadrement actuel")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Propositions de nouveaux schémas d\'organisation")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Profils types et pratiques innovantes")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Critères et seuils nécessaires à la pérennité de l\'emploi")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Présentation")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Fonctionnement")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Objectifs")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Nouveaux Diplômes")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Les enjeux climatiques, énergétiques et économiques")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Sport et développement durable")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Démarche fédérale")');
        $this->addSql('INSERT INTO theme (libelle) VALUES ("Echange")');
        
        
        $this->addSql('INSERT INTO hotel (nom,adresse1,adresse2,cp,ville,tel,mail) VALUES ("ibis Styles Lille Centre Gare Beffroi","172 rue Pierre Mauroy","",59000,"Lille",0320300054,"H1384@accor.com")');
        $this->addSql('INSERT INTO hotel (nom,adresse1,adresse2,cp,ville,tel,mail) VALUES ("ibis budget Lille Centre","10, Rue de Courtrai","",59000,"Lille",0892683078,"H5208@accor.com")');

        
 

        

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE atelier');
        $this->addSql('TRUNCATE TABLE hotel');
    }
}
