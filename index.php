<?php //stuff for displaying errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "./php/misc/autoloader.php";

$pageService = new PageService();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <base href="/"> <!-- makes it so that relative links go from the root -->

    <!-- main styling for the entire page -->
    <link href="./style/css/main.min.css" rel="stylesheet">

    <link rel="icon" href="./assets/icons/favicon.ico" type="image/jpg">
    <title>cool-page-setup</title>
</head>

<body>
    <header>
        <section>
            <?php include "./views/parts/header.phtml"; ?>
        </section>
    </header>

    <main>
        <section>
            <?php
                $pageService->loadModel();
            ?>
        </section>
    </main>

    <footer>
        <section>
            <?php include "./views/parts/footer.phtml"; ?>
        </section>
    </footer>
</body>

</html>