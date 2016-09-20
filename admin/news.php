<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=news'));
    }

    /****************************************************************************
     * DIN OPGAVE!
     *
     * 1. Denne side skal tjekke om brugeren der er logget på, er redaktør og om
     *    redaktøreren har rettigheder til at skrive i den pågældende kategori
     *    Er man redaktør i kategorien, har man FULD ret til at oprette, rette og
     *    slette samtlige nyheder i den pågældende kategori.
     ****************************************************************************/

    if (isset($_GET['category_id']))
    {
        $category_id = ($_GET['category_id'] * 1);
        if(isset($_SESSION['user']['acl']) && !in_array($category_id,$_SESSION['user']['acl'])){
            header('location:index.php');
            exit;
        }
        $category_title = 'Nyheds';
        $query = "SELECT category_title FROM categories WHERE category_id = '$category_id'";
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
        if (mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_assoc($result);
            $category_title = $row['category_title'];
        }
        echo '<h2>'.$category_title.' Nyheder</h2>';
    }
    else
    {
        echo '<h2>Nyheds Administration</h2>';
    }

    // her findes der ud af hvilken del af kategori admin der skal vises
    // baseret på om der står en action i adressebaren
    if (isset($_GET['action']))
    {
        switch($_GET['action'])
        {
            case 'add' :
                include ('page_functions/news_add.php');
                break;
            case 'edit' :
                include ('page_functions/news_edit.php');
                break;
            case 'delete' :
                include ('page_functions/news_delete.php');
                break;
        }
    }
    else
    {
        // hvis der ikke står en action i URL, så hentes listen
        include ('page_functions/news_list.php');
    }
?>