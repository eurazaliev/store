<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326103550 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country CHANGE memo memo VARCHAR(190) DEFAULT NULL');
        $this->addSql('ALTER TABLE language CHANGE memo memo VARCHAR(190) DEFAULT NULL');
        $this->addSql('ALTER TABLE vendor CHANGE permit permit TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE search_server ADD created_at DATETIME NOT NULL, CHANGE cluster_id_id cluster_id_id INT DEFAULT NULL, CHANGE os_id_id os_id_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE is_vm is_vm TINYINT(1) DEFAULT NULL, CHANGE mem_min mem_min INT DEFAULT NULL, CHANGE mem_max mem_max INT DEFAULT NULL, CHANGE cpu_min cpu_min INT DEFAULT NULL, CHANGE cpu_max cpu_max INT DEFAULT NULL, CHANGE hdd_min hdd_min INT DEFAULT NULL, CHANGE hdd_max hdd_max INT DEFAULT NULL, CHANGE on_off on_off TINYINT(1) DEFAULT NULL, CHANGE ip_addr ip_addr VARCHAR(255) DEFAULT NULL, CHANGE count count INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country CHANGE memo memo VARCHAR(190) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE language CHANGE memo memo VARCHAR(190) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE search_server DROP created_at, CHANGE cluster_id_id cluster_id_id INT DEFAULT NULL, CHANGE os_id_id os_id_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE is_vm is_vm TINYINT(1) DEFAULT \'NULL\', CHANGE mem_min mem_min INT DEFAULT NULL, CHANGE mem_max mem_max INT DEFAULT NULL, CHANGE cpu_min cpu_min INT DEFAULT NULL, CHANGE cpu_max cpu_max INT DEFAULT NULL, CHANGE hdd_min hdd_min INT DEFAULT NULL, CHANGE hdd_max hdd_max INT DEFAULT NULL, CHANGE on_off on_off TINYINT(1) DEFAULT \'NULL\', CHANGE ip_addr ip_addr VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE count count INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vendor CHANGE permit permit TINYINT(1) DEFAULT \'NULL\'');
    }
}
