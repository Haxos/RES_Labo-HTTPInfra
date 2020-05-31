<?php

namespace MgmtUi\Helpers;

use Docker\API\Model\ContainerSummaryItem;
use Docker\API\Model\EndpointSettings;
use Docker\API\Model\ImageSummary;

class DockerHelper
{
    public static function imageHasTag(ImageSummary $image, string $pattern) : bool
    {
        return self::getFirstTagMatchingPattern($image->getRepoTags(), $pattern) !== null;
    }

    public static function imageHasAnyTag(ImageSummary $image, array $pattern) : bool
    {
        return self::getFirstTagMatchingPatterns($image->getRepoTags(), $pattern) !== null;
    }

    public static function getImageName(ImageSummary $image): ?string
    {
        return self::getFirstTagMatchingPatterns(
            $image->getRepoTags(),
            ConfigHelper::instance()->get('managedImages', [])
        );
    }

    public static function getFirstTagMatchingPattern(array $tags, string $pattern) : ?string
    {
        foreach ($tags as $tag)
        {
            $imageName = substr($tag, 0, strrpos($tag, ':'));

            if (fnmatch($pattern, $imageName))
                return $tag;
        }

        return null;
    }

    public static function getFirstTagMatchingPatterns(array $tags, array $patterns) : ?string
    {
        foreach ($patterns as $pattern)
        {
            $result = self::getFirstTagMatchingPattern($tags, $pattern);

            if ($result !== null)
                return $result;
        }

        return null;
    }

    public static function getContainerIpV4(ContainerSummaryItem $container) : array
    {
        $ips = [];
        $networkSettings = $container->getNetworkSettings();

        /** @var EndpointSettings $network */
        foreach ($networkSettings->getNetworks() as $networkName => $network)
        {
            if (empty($network->getIPAddress()))
                continue;

            $ips[$networkName] = $network->getIPAddress();
        }

        return $ips;
    }
}
