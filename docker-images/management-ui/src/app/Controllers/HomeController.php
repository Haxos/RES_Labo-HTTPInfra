<?php

namespace MgmtUi\Controllers;

use Docker\API\Model\ContainerSummaryItem;
use Docker\API\Model\ImageSummary;
use Docker\Docker;
use MgmtUi\Base\Controller;
use MgmtUi\Helpers\ConfigHelper;
use MgmtUi\Helpers\DockerHelper;

class HomeController extends Controller
{
    public function home()
    {
        $docker = Docker::create();

        return $this->renderView('home', [
            'imagesList' => $this->getImagesList($docker),
            'containersByImage' => $this->getContainersByImage($docker),
        ]);
    }

    private function getImagesList(Docker $docker)
    {
        $images = [];
        $manageableTags = ConfigHelper::instance()->get('managedImages', []);

        foreach ($docker->imageList() as $image)
        {
            if (DockerHelper::imageHasAnyTag($image, $manageableTags))
            {
                $images[] = $image;
            }
        }

        return $images;
    }

    private function getContainersByImage(Docker $docker)
    {
        /** @var ImageSummary[] $images */
        $images = $this->getImagesList($docker);

        /** @var ContainerSummaryItem[] $containers */
        $containers = $docker->containerList();
        
        $containersByImage = [];
        $manageableTags = ConfigHelper::instance()->get('managedImages', []);

        foreach ($images as $image)
        {
            $imageName = DockerHelper::getFirstTagMatchingPatterns($image->getRepoTags(), $manageableTags);

            if ($imageName === null)
                continue;

            $containersByImage[$imageName] = [];

            foreach ($containers as $container)
            {
                if ($container->getImageID() === $image->getId())
                {
                    $containersByImage[$imageName][] = $container;
                }
            }
        }

        return $containersByImage;
    }
}
