<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Models\RecordManagers;

use Hubleto\App\Community\Auth\Models\RecordManagers\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventHasUser extends \Hubleto\Erp\RecordManager
{
  public $table = 'ohs_event_has_users';

  public function EVENT(): BelongsTo
  {
    return $this->belongsTo(Event::class, 'id_event', 'id');
  }

  public function USER(): BelongsTo
  {
    return $this->belongsTo(User::class, 'id_user', 'id');
  }

  public function addUrlFiltersToQuery(mixed $query): mixed
  {
    $query = parent::addUrlFiltersToQuery($query);

    $idEvent = \Hubleto\Erp\Loader::getGlobalApp()->router()->urlParamAsInteger('idEvent');
    if ($idEvent > 0) {
      $query = $query->where($this->table . '.id_event', $idEvent);
    }
    return $query;
  }

  public function prepareLookupData(array $dataRaw): array
  {
    return parent::prepareLookupData($dataRaw);
  }
}
