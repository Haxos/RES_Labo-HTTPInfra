<?php

namespace MgmtUi\Controllers;

use MgmtUi\Base\Controller;

class HomeController extends Controller
{
    public function home()
    {
        return $this->renderView('Home');
    }
}
