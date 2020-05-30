<!DOCTYPE html>
<?php

use Carbon\Carbon;
use Docker\API\Model\ContainerSummaryItem;
use Docker\API\Model\ImageSummary;
use MgmtUi\Helpers\DockerHelper;
use MgmtUi\Helpers\NumberHelper;
use MgmtUi\Helpers\PathHelper;
use MgmtUi\Helpers\UrlHelper;

?>
<html>
<?php include PathHelper::viewPath('partials/head.php'); ?>

<body>
    <main class="container">
        <h1>Management UI</h1>

        <h2>Images</h2>
        <ul class="row list-unstyled images-list">
            <?php foreach ($imagesList as $image) : ?>
                <?php /** @var ImageSummary $image */ ?>
                <li class="image">
                    <div class="card">
                        <h3 class="image-name"><?= DockerHelper::getImageName($image) ?></h3>
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Création:</td>
                                    <td><?= Carbon::createFromTimestamp($image->getCreated())->format('d.m.Y H:i:s') ?></td>
                                </tr>
                                <tr>
                                    <td>Taille:</td>
                                    <td><?= NumberHelper::make($image->getSize())->unit('o')->humanFriendly() ?></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="actions row">
                            <form action="<?= UrlHelper::url("image/" . $image->getId() . "/create-container") ?>" method="POST">
                                <button>Nouveau container</button>
                            </form>
                        </div>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>

        <h2>Containers</h2>
        <ul class="row list-unstyled containers-images-list">
            <?php foreach ($containersByImage as $image => $containers) : ?>
                <li class="image">
                    <div class="card">
                        <h3 class="image-title"><?= $image ?></h3>

                        <ul class="list-unstyled card-full-width containers-list">
                            <?php foreach ($containers as $container) : ?>
                                <?php /** @var ContainerSummaryItem $container */ ?>
                                <li class="container">
                                    <table class="info-table">
                                        <tbody>
                                            <tr>
                                                <td>Noms:</td>
                                                <td><?= implode('<br />', $container->getNames()) ?></td>
                                            </tr>
                                            <tr>
                                                <td>État:</td>
                                                <td><?= $container->getState() ?></td>
                                            </tr>
                                            <tr>
                                                <td>Status:</td>
                                                <td><?= $container->getStatus() ?></td>
                                            </tr>
                                            <tr>
                                                <td>IPv4:</td>
                                                <td><?= implode('<br />', DockerHelper::getContainerIpV4($container)) ?></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div class="actions row">
                                        <?php if ($container->getState() === 'running') : ?>
                                            <form action="<?= UrlHelper::url("container/" . $container->getId() . "/stop") ?>" method="POST">
                                                <button>Pause</button>
                                            </form>
                                        <?php else : ?>
                                            <form action="<?= UrlHelper::url("container/" . $container->getId() . "/start") ?>" method="POST">
                                                <button>Reprendre</button>
                                            </form>
                                        <?php endif; ?>
                                        <form action="<?= UrlHelper::url("container/" . $container->getId() . "/restart") ?>" method="POST">
                                            <button>Redémarrer</button>
                                        </form>
                                        <form action="<?= UrlHelper::url("container/" . $container->getId() . "/delete") ?>" method="POST">
                                            <button>Supprimer</button>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
    </main>
</body>

</html>
