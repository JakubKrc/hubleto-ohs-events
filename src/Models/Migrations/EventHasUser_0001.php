<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Models\Migrations;

use Hubleto\Framework\Migration;

class EventHasUser_0001 extends Migration
{
  public function upgradeSchema(): void
  {
    $this->db->execute("CREATE TABLE IF NOT EXISTS `ohs_event_has_users` (
      `id` int(8) primary key auto_increment,
      `id_event` int(8) NOT NULL,
      `id_user` int(8) NOT NULL,
      UNIQUE INDEX `event_has_user` (`id_event`, `id_user`),
      INDEX `id_user` (`id_user`)
    ) ENGINE=InnoDB");
  }

  public function downgradeSchema(): void
  {
    $this->db->execute("DROP TABLE IF EXISTS `ohs_event_has_users`");
  }

  public function upgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `ohs_event_has_users` ADD CONSTRAINT `fk__ohs_event_has_users__id_event` FOREIGN KEY (`id_event`) REFERENCES `ohs_events` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT");
    $this->db->execute("ALTER TABLE `ohs_event_has_users` ADD CONSTRAINT `fk__ohs_event_has_users__id_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT");
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `ohs_event_has_users` DROP FOREIGN KEY `fk__ohs_event_has_users__id_event`");
    $this->db->execute("ALTER TABLE `ohs_event_has_users` DROP FOREIGN KEY `fk__ohs_event_has_users__id_user`");
  }
}
