<?php
    // start outputbuffer, så indholdet først sendes til browseren
    // når alt indholdet på siden er genereret
    ob_start();
    // start session, så vi kan holde styr på hvem der er logget på
    session_start();
    // under udviklingen af siden, sættes error_reporting til E_ALL
    // så kommer alle advarsler og beskeder frem på skærmen  
    error_reporting(E_ALL);
    // åben forbindelsen til databsen
    require_once ('../assets/database_connection.php');
    // hent hjælpe funktioner
    require_once ('../assets/functions.php');


    // dette er administrations siderne, så det er vigtigt at sikre brugeren har
    // rettighed til at se siden, man skal være logget på
    if ( !isset($_SESSION['user']))
    {
        die('<p class="alert alert-danger">
                 <strong>ADVARSEL</strong> du skal v&aelig;re logget p&aring;, for at se denne side.  
                 <a href="../index.php?page=login" class="btn btn-primary">G&aring; til Login</a>
             </p>');
    }

    // rolle rettigheder er sat sådan op, at 
    // man skal have rettighed niveau 10 eller derover
    // for at få adgang til redaktør funktionerne,
    // som her ligger på admin siden
    if ($_SESSION['user']['role_access'] < 10)
    {
        die('<p class="alert alert-danger">
                 <strong>ADVARSEL</strong> du v&aelig;re moderator eller administrator, for at se denne side.  
                 <a href="../index.php?page=login" class="btn btn-primary">G&aring; til Login</a>
             </p>');
    }
    
    // her sættes standard siden der vises
    $page_backend = 'backend.php';
    // her findes ud af hvilke side der vises
    require_once ('includes/page_backend.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="utf-8">
		<title>Dynamisk Webproduktion</title>
		<!-- http://www.bootstrapcdn.com/ -->
		<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.no-icons.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
		<link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/slate/bootstrap.min.css" rel="stylesheet">
		<!-- Særlige styles der overskriver Bootstrap -->
		<link href="../assets/css/backend.css" rel="stylesheet" type="text/css" />

	</head>
	<body>
		<div class="container">
			<header>
				<h1 class="well">Dynamisk Webproduktion Administration</h1>
			</header>

			<div class="row">
				<nav class="col-lg-3 ">
					<?php
                        // her indlæses menuen
                        include ('includes/menu.php');
					?>
				</nav>

				<section class="col-lg-9">
					<?php
                        // her indlæses den ønskede fil
                        include ($page_backend);

                        // udskriv en besked, hvis der ligger en i session
                        // f.eks. om noget blev indsat eller opdateret
                        if (isset($_SESSION['message']))
                        {
                            
                            echo '
                            	<div class="alert alert-info alert-dismissable">
                            		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            		<p>'.$_SESSION['message'].'</p>
                        		</div>';
                            // efter beskeden er udskrevet,
                            // så slet den fra session, så den ikke kommer
                            unset($_SESSION['message']);
                        }
					?>
				</section>
			</div>

			<footer>
				<p>
					CMK News 2005 - <?php echo date('Y');?>
				</p>
			</footer>
		</div>
		<?php
            // udskriv debug informationer
            print_debug_info();
		?>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
		<script src="../assets/ckeditor/ckeditor.js"></script>
		<script src="../assets/ckeditor/config.js"></script>
		<script src="../assets/ckeditor/styles.js"></script>
		<script>if($('#news_content').length){CKEDITOR.replace( 'news_content' );}</script>
	</body>
</html>

