<?php
    $database_host = 'localhost';
    $database_user = 'root';
    $database_pass = '';
    $database_name = 'hfp2_nco_nyhedssite';

    // hvis det ikke kan lade sig gøre at forbinde til databasen,
    // så udskrives der en fejlbesked
    if ( !$database_link = @mysqli_connect($database_host, $database_user, $database_pass, $database_name))
    {
        die('<p class="alert alert-danger">
                 <strong>ADVARSEL</strong> Forbindelsen til databasen fejler... <br />
                 Tjek forbindelses informationerne i filen:<br /> 
                 <strong>'.__FILE__.'</strong>
             </p>');
    }
?>