<?php
    // denne fil må ikke kunne indlæses direkte, så hvis der ikke findes et
    // databaselink, sendes brugeren til forsiden
    if ( !isset($database_link))
    {
        die(header('location: ../index.php'));
    }

    // find ud af hvilken side der skal vises.
    // hvis der står "page" i URL, testes om det er en tilladt side
    if (isset($_GET['page']))
    {
        // her definerer vi hvilke filer der er tilladt at vise
        $allowed_pages_backend = array(
            'backend',
            'categories',
            'editors',
            'users',
            'news'
        );
        // her tjekkes om page fra URL'en, er en af de tilladte filnavne
        if (in_array($_GET['page'], $allowed_pages_backend))
        {
            // hvis $_GET['page'] er et tilladt filnavn, så tilføjer vi ".php"
            $page_backend = $_GET['page'].'.php';
        }
        else
        {
            // hvis den ikke er tilladt, så sendes brugeren til index.php
            die(header('location: index.php'));
        }
    }
?>