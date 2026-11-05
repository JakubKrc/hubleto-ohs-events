<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Controllers;

class EventHasUsers extends \Hubleto\Erp\Controller
{
  public function prepareView(): void
  {
    parent::prepareView();
    $this->setView('@Hubleto:App:External:WaiBlue:OhsEvents/EventHasUsers.twig');
  }
}
