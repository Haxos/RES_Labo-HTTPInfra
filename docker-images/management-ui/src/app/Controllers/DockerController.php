<?php

namespace MgmtUi\Controllers;

use Docker\Docker as DockerManager;
use MgmtUi\Base\Controller;

class DockerController extends Controller
{
    public function test()
    {
        $dockerManager = new DockerManager();
    }
}
