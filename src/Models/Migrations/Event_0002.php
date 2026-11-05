<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Models\Migrations;

use Hubleto\Framework\Migration;

// A car with bookings cannot be deleted, so the bookings stay.
class Event_0002 extends Migration
{
  public function upgradeSchema(): void
  {
  }

  public function downgradeSchema(): void
  {
  }

  public function upgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `ohs_events` DROP FOREIGN KEY `fk__ohs_events__id_car`");
    $this->db->execute("ALTER TABLE `ohs_events` ADD CONSTRAINT `fk__ohs_events__id_car` FOREIGN KEY (`id_car`) REFERENCES `ohs_cars` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT");
  }

  public function downgradeForeignKeys(): void
  {
    $this->db->execute("ALTER TABLE `ohs_events` DROP FOREIGN KEY `fk__ohs_events__id_car`");
    $this->db->execute("ALTER TABLE `ohs_events` ADD CONSTRAINT `fk__ohs_events__id_car` FOREIGN KEY (`id_car`) REFERENCES `ohs_cars` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT");
  }
}
