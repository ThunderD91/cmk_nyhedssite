<?php
    // start outputbuffer, så indholdet først sendes til browseren
    // når alt indholdet på siden er genereret
    ob_start();
    // start session, så vi kan holde styr på hvem der er logget på
    session_start();

    // under udviklingen af siden, sættes error_reporting til E_ALL
    // så kommer alle advarsler og beskeder frem på skærmen
    error_reporting(E_ALL);
    // fortæl serveren at den skal benytte danske standarder
    // Især vigtigt når der udskrives datoer og tider
    setlocale(LC_ALL, "danish");

    // åben forbindelsen til databsen
    require_once ('assets/database_connection.php');
    // hent hjælpe funktioner
    require_once ('assets/functions.php');

    // her sættes standard siden der vises
    $page_frontend = 'frontpage.php';
    // her findes ud af hvilke side der vises
    require_once ('includes/page_frontend.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="utf-8">
        <title>Dynamisk Webproduktion Nyhedssite</title>
        <!-- http://www.bootstrapcdn.com/ -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
        <link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/flatly/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/frontend.css" rel="stylesheet" type="text/css" />

    </head>
    <body>
        <div class="container wrapper">
            <header>
                <h1>Dynamisk Webproduktion Nyhedssite</h1>
            </header>

            <nav class="top">
                <?php
                    // inkluder menuen
                    include ('includes/menu.php');
                ?>
            </nav>

            <section>
                <?php
                    // her indlæses den ønskede fil
                    include ($page_frontend);
                ?>
            </section>

            <footer>
                <p>
                    CMK News 2005 - <?php echo date('Y');?>
                </p>
            </footer>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <?php
            // udskriv debug informationer, funktionen ligger i functions.php
            print_debug_info();
        ?>
    </body>
</html>

