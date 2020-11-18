<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201118145607 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, income INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, admin_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, solde INT NOT NULL, address VARCHAR(255) NOT NULL, INDEX IDX_81398E09642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_restaurant (customer_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_165C16BD9395C3F3 (customer_id), INDEX IDX_165C16BDB1E7706E (restaurant_id), PRIMARY KEY(customer_id, restaurant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE meal (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, price INT NOT NULL, note INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, order_hour DATE NOT NULL, delivery_hour DATE NOT NULL, nbr_meal INT NOT NULL, price INT NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_customer (order_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_60C16CB88D9F6D38 (order_id), INDEX IDX_60C16CB89395C3F3 (customer_id), PRIMARY KEY(order_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_meal (order_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_D307B48B8D9F6D38 (order_id), INDEX IDX_D307B48B639666D6 (meal_id), PRIMARY KEY(order_id, meal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant (id INT AUTO_INCREMENT NOT NULL, admin_id INT NOT NULL, name VARCHAR(255) NOT NULL, logo VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, income INT NOT NULL, INDEX IDX_EB95123F642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE customer_restaurant ADD CONSTRAINT FK_165C16BD9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_restaurant ADD CONSTRAINT FK_165C16BDB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_customer ADD CONSTRAINT FK_60C16CB88D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_customer ADD CONSTRAINT FK_60C16CB89395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_meal ADD CONSTRAINT FK_D307B48B8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_meal ADD CONSTRAINT FK_D307B48B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant ADD CONSTRAINT FK_EB95123F642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09642B8210');
        $this->addSql('ALTER TABLE restaurant DROP FOREIGN KEY FK_EB95123F642B8210');
        $this->addSql('ALTER TABLE customer_restaurant DROP FOREIGN KEY FK_165C16BD9395C3F3');
        $this->addSql('ALTER TABLE order_customer DROP FOREIGN KEY FK_60C16CB89395C3F3');
        $this->addSql('ALTER TABLE order_meal DROP FOREIGN KEY FK_D307B48B639666D6');
        $this->addSql('ALTER TABLE order_customer DROP FOREIGN KEY FK_60C16CB88D9F6D38');
        $this->addSql('ALTER TABLE order_meal DROP FOREIGN KEY FK_D307B48B8D9F6D38');
        $this->addSql('ALTER TABLE customer_restaurant DROP FOREIGN KEY FK_165C16BDB1E7706E');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_restaurant');
        $this->addSql('DROP TABLE meal');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_customer');
        $this->addSql('DROP TABLE order_meal');
        $this->addSql('DROP TABLE restaurant');
    }
}
