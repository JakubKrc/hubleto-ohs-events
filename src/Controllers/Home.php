<?php

namespace Hubleto\App\External\WaiBlue\OhsEvents\Controllers;

class Home extends \Hubleto\Erp\Controller
{
  public function prepareView(): void
  {
    parent::prepareView();
    $this->viewParams['carBookingsUrl'] = \Hubleto\App\External\WaiBlue\OhsEvents\Loader::CAR_BOOKINGS_URL;
    $this->setView('@Hubleto:App:External:WaiBlue:OhsEvents/Home.twig');
  }
}
