<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230426080216 extends AbstractMigration {

    public function getDescription(): string {
        return '';
    }

    public function up(Schema $schema): void {

        $this->addSql('SET FOREIGN_KEY_CHECKS=0;');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,1)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,2)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,3)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,4)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,5)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (1,6)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (2,7)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (2,8)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (2,9)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (2,10)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (2,11)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,12)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,13)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,14)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,15)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,16)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (3,17)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (4,18)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (4,19)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (4,20)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (4,21)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (4,22)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (5,23)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (5,24)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (5,25)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (5,26)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (5,4)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (6,27)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (6,28)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (6,29)');
        $this->addSql('INSERT INTO atelier_theme (atelier_id,theme_id) VALUES (6,30)');
        $this->addSql('SET FOREIGN_KEY_CHECKS=1;');
    }

    public function down(Schema $schema): void {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('TRUNCATE TABLE atelier_theme');
    }

}
