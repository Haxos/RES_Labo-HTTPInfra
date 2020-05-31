<?php

namespace MgmtUi\Controllers;

use Docker\API\Model\ContainersCreatePostBody;
use Docker\Docker;
use Klein\Request;
use MgmtUi\Base\Controller;

class DockerController extends Controller
{
    public function test()
    {
        $docker = Docker::create();
        
        var_dump($docker->containerList());
    }

    public function createContainer(Request $request)
    {
        $docker = Docker::create();

        $containerConfig = new ContainersCreatePostBody();
        $containerConfig->setImage($request->imageId);

        $containerCreateResult = $docker->containerCreate($containerConfig);
        $docker->containerStart($containerCreateResult->getId());

        return $this->redirect('/');
    }

    public function deleteContainer(Request $request)
    {
        $docker = Docker::create();

        $docker->containerStop($request->containerId);
        $docker->containerDelete($request->containerId);

        return $this->redirect('/');
    }

    public function startContainer(Request $request)
    {
        Docker::create()->containerUnpause($request->containerId);

        return $this->redirect('/');
    }

    public function stopContainer(Request $request)
    {
        Docker::create()->containerPause($request->containerId);

        return $this->redirect('/');
    }

    public function restartContainer(Request $request)
    {
        Docker::create()->containerRestart($request->containerId);

        return $this->redirect('/');
    }
}
