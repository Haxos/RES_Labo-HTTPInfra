<!DOCTYPE html>

<?php
$pageTitle = 'Home';
?>

<html lang="en">

<head>
    <?php include __DIR__ . '/../partials/head.php' ?>
</head>

<body>
    <?php include __DIR__ . '/../partials/header.php' ?>

    <main id="main">
        <div class="home-banner mb-5">
            <h1>Hello World</h1>
        </div>

        <div class="container content">
            <h2>AJAX !!!</h2>
            <div class="displayer">
            </div>
            <h2>
                <span class="anchor" id="section-1"></span>
                Section 1
            </h2>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
            
            <h2>
                <span class="anchor" id="section-2"></span>
                Section 2
            </h2>
            <p>Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?</p>
        </div>
    </main>

    <?php include __DIR__ . '/../partials/footer.php' ?>
    <?php include __DIR__ . '/../partials/scripts.php' ?>    
</body>

</html>

<script
    src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
    crossorigin="anonymous"
></script>
<script src="js/transactions.js"></script>
