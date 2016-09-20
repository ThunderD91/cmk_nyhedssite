<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=users'));
    }

    echo '<h2>Bruger Administration</h2>';

    // her findes der ud af hvilken del af bruger admin der skal vises
    // baseret på om der står en action i adressebaren
    if (isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'add' :
                include ('page_functions/user_add.php');
                break;
            case 'edit' :
                include ('page_functions/user_edit.php');
                break;
            case 'delete' :
                include ('page_functions/user_delete.php');
                break;
        }
    }
    else
    {
        // hvis der ikke står en action i URL, så hentes listen
        include ('page_functions/user_list.php');
    }
?>