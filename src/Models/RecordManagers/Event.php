<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Models\RecordManagers;

use Hubleto\App\External\WaiBlue\OhsCore\Models\RecordManagers\Traits\DefaultOrder;
use Hubleto\App\Community\Auth\Models\RecordManagers\User;
use Hubleto\App\External\WaiBlue\OhsCore\Models\RecordManagers\Car;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends \Hubleto\Erp\RecordManager
{
  use DefaultOrder;

  public $table = 'ohs_events';

  const TYPE_FILTER = 'fEventType';
  const TYPE_FILTER_ALL = 0;
  const TYPE_FILTER_EVENTS = 1;
  const TYPE_FILTER_CAR_BOOKINGS = 2;

  public function USER(): BelongsTo
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }

  public function CAR(): BelongsTo
  {
    return $this->belongsTo(Car::class, 'id_car', 'id');
  }

  // Events of one user: own events, events the user attends and events "for all" (both legacy calendars).
  public function filterByUser(mixed $query, int $idUser): mixed
  {
    return $query->where(function ($eventsOfUser) use ($idUser) {
      $eventsOfUser->where($this->table . '.id_user', $idUser);
      $eventsOfUser->orWhereIn($this->table . '.id', $this->idsOfEventsAttendedBy($idUser));
      $eventsOfUser->orWhere($this->table . '.is_public', 1);
    });
  }

  private function idsOfEventsAttendedBy(int $idUser): \Closure
  {
    return function ($attendedEventIds) use ($idUser) {
      $attendedEventIds->select('id_event')->from('ohs_event_has_users')->where('id_user', $idUser);
    };
  }

  public function addUrlFiltersToQuery(mixed $query): mixed
  {
    $query = parent::addUrlFiltersToQuery($query);

    $hubleto = \Hubleto\Erp\Loader::getGlobalApp();
    $router = $hubleto->router();

    // Car form tab "Plánovanie vozidiel".
    $idCar = $router->urlParamAsInteger('idCar');
    if ($idCar > 0) {
      $query = $query->where($this->table . '.id_car', $idCar);
    }

    $filters = $router->urlParamAsArray('filters');
    $type = (int) ($filters[self::TYPE_FILTER] ?? self::TYPE_FILTER_ALL);
    if ($type == self::TYPE_FILTER_EVENTS) {
      $query = $query->whereNull($this->table . '.id_car');
    }
    if ($type == self::TYPE_FILTER_CAR_BOOKINGS) {
      $query = $query->whereNotNull($this->table . '.id_car');
    }

    return $query;
  }

  public function prepareLookupData(array $dataRaw): array
  {
    return parent::prepareLookupData($dataRaw);
  }
}
