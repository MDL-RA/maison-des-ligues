<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426081936 extends AbstractMigration {

    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO categorie_chambre (libelle_categorie) VALUES ("Single")');
        $this->addSql('INSERT INTO categorie_chambre (libelle_categorie) VALUES ("Double")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (1,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (1,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (1,"2022-09-17 16:00:00","2022-09-17 17:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (2,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (2,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (2,"2022-09-17 16:00:00","2022-09-17 17:30:00")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (3,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (3,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (3,"2022-09-17 16:00:00","2022-09-17 17:30:00")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (4,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (4,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (4,"2022-09-17 16:00:00","2022-09-17 17:30:00")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (5,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (5,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (5,"2022-09-17 16:00:00","2022-09-17 17:30:00")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (6,"2022-09-17 11:00:00","2022-09-17 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (6,"2022-09-17 14:00:00","2022-09-17 15:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (6,"2022-09-17 16:00:00","2022-09-17 17:30:00")');
        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (1,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (1,"2022-09-18 11:00:00","2022-09-18 12:30:00")');
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (2,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (2,"2022-09-18 11:00:00","2022-09-18 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (3,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (3,"2022-09-18 11:00:00","2022-09-18 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (4,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (4,"2022-09-18 11:00:00","2022-09-18 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (5,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (5,"2022-09-18 11:00:00","2022-09-18 12:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (6,"2022-09-18 09:30:00","2022-09-18 10:30:00")');        
        $this->addSql('INSERT INTO vacation (atelier_id,date_heure_debut,date_heure_fin) VALUES (6,"2022-09-18 11:00:00","2022-09-18 12:30:00")');        
        
       

 
       
        
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE vacation');
        $this->addSql('TRUNCATE TABLE categorie_chambre');
    }

}
