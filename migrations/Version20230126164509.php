<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230126164509 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE client_order (id INT AUTO_INCREMENT NOT NULL, serveur_id INT DEFAULT NULL, num_table_id INT DEFAULT NULL, num_commande VARCHAR(255) NOT NULL, date_commande DATETIME NOT NULL, prix DOUBLE PRECISION NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_56440F2FB8F06499 (serveur_id), INDEX IDX_56440F2F35EC719A (num_table_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_order_dish (client_order_id INT NOT NULL, dish_id INT NOT NULL, INDEX IDX_48D88BEEA3795DFD (client_order_id), INDEX IDX_48D88BEE148EB0CB (dish_id), PRIMARY KEY(client_order_id, dish_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE client_order ADD CONSTRAINT FK_56440F2FB8F06499 FOREIGN KEY (serveur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE client_order ADD CONSTRAINT FK_56440F2F35EC719A FOREIGN KEY (num_table_id) REFERENCES client_table (id)');
        $this->addSql('ALTER TABLE client_order_dish ADD CONSTRAINT FK_48D88BEEA3795DFD FOREIGN KEY (client_order_id) REFERENCES client_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_order_dish ADD CONSTRAINT FK_48D88BEE148EB0CB FOREIGN KEY (dish_id) REFERENCES dish (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client_order DROP FOREIGN KEY FK_56440F2FB8F06499');
        $this->addSql('ALTER TABLE client_order DROP FOREIGN KEY FK_56440F2F35EC719A');
        $this->addSql('ALTER TABLE client_order_dish DROP FOREIGN KEY FK_48D88BEEA3795DFD');
        $this->addSql('ALTER TABLE client_order_dish DROP FOREIGN KEY FK_48D88BEE148EB0CB');
        $this->addSql('DROP TABLE client_order');
        $this->addSql('DROP TABLE client_order_dish');
    }
}
