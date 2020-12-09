<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201209145305 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE meal_order (meal_id INT NOT NULL, order_id INT NOT NULL, INDEX IDX_4FE37B4E639666D6 (meal_id), INDEX IDX_4FE37B4E8D9F6D38 (order_id), PRIMARY KEY(meal_id, order_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE restaurant_customer (restaurant_id INT NOT NULL, customer_id INT NOT NULL, INDEX IDX_A19C40E6B1E7706E (restaurant_id), INDEX IDX_A19C40E69395C3F3 (customer_id), PRIMARY KEY(restaurant_id, customer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE meal_order ADD CONSTRAINT FK_4FE37B4E639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE meal_order ADD CONSTRAINT FK_4FE37B4E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_customer ADD CONSTRAINT FK_A19C40E6B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE restaurant_customer ADD CONSTRAINT FK_A19C40E69395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE customer_restaurant');
        $this->addSql('DROP TABLE order_meal');
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE income income DOUBLE PRECISION NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('ALTER TABLE customer ADD roles JSON NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE solde solde DOUBLE PRECISION NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E09E7927C74 ON customer (email)');
        $this->addSql('ALTER TABLE meal CHANGE restaurant_id restaurant_id INT DEFAULT NULL, CHANGE price price DOUBLE PRECISION NOT NULL, CHANGE note note INT NOT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE restaurant ADD roles JSON NOT NULL, CHANGE admin_id admin_id INT DEFAULT NULL, CHANGE income income DOUBLE PRECISION NOT NULL, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB95123FE7927C74 ON restaurant (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer_restaurant (customer_id INT NOT NULL, restaurant_id INT NOT NULL, INDEX IDX_165C16BD9395C3F3 (customer_id), INDEX IDX_165C16BDB1E7706E (restaurant_id), PRIMARY KEY(customer_id, restaurant_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_meal (order_id INT NOT NULL, meal_id INT NOT NULL, INDEX IDX_D307B48B8D9F6D38 (order_id), INDEX IDX_D307B48B639666D6 (meal_id), PRIMARY KEY(order_id, meal_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE customer_restaurant ADD CONSTRAINT FK_165C16BD9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_restaurant ADD CONSTRAINT FK_165C16BDB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_meal ADD CONSTRAINT FK_D307B48B639666D6 FOREIGN KEY (meal_id) REFERENCES meal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_meal ADD CONSTRAINT FK_D307B48B8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE meal_order');
        $this->addSql('DROP TABLE restaurant_customer');
        $this->addSql('DROP INDEX UNIQ_880E0D76E7927C74 ON admin');
        $this->addSql('ALTER TABLE admin DROP roles, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE income income INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_81398E09E7927C74 ON customer');
        $this->addSql('ALTER TABLE customer DROP roles, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE solde solde INT NOT NULL');
        $this->addSql('ALTER TABLE meal CHANGE restaurant_id restaurant_id INT NOT NULL, CHANGE price price INT NOT NULL, CHANGE note note INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE price price INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_EB95123FE7927C74 ON restaurant');
        $this->addSql('ALTER TABLE restaurant DROP roles, CHANGE admin_id admin_id INT NOT NULL, CHANGE email email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE income income INT NOT NULL');
    }
}
