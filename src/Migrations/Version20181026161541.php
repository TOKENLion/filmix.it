<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181026161541 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_film (actor_id INT NOT NULL, film_id INT NOT NULL, INDEX IDX_B20C8CD110DAF24A (actor_id), INDEX IDX_B20C8CD1567F5183 (film_id), PRIMARY KEY(actor_id, film_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, studio_id INT NOT NULL, name VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, date_create DATETIME NOT NULL, INDEX IDX_8244BE22446F285F (studio_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film_studio (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, phone VARCHAR(15) NOT NULL, address VARCHAR(255) NOT NULL, date_create DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_film ADD CONSTRAINT FK_B20C8CD110DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_film ADD CONSTRAINT FK_B20C8CD1567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE22446F285F FOREIGN KEY (studio_id) REFERENCES film_studio (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_film DROP FOREIGN KEY FK_B20C8CD110DAF24A');
        $this->addSql('ALTER TABLE actor_film DROP FOREIGN KEY FK_B20C8CD1567F5183');
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE22446F285F');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_film');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE film_studio');
    }
}
