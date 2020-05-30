<?php

namespace MgmtUi\Controllers;

use MgmtUi\Base\Controller;

class Home extends Controller
{
    public function home()
    {
        return $this->renderView('Home');
    }
}
