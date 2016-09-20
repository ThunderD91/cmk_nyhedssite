<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=news'));
    }

    // denne fil er afhængig af at have en kategori id i URL
    // findes den ikke, så returneres brugeren til nyhedslisten
    if ( !isset($_GET['category_id']))
    {
        die(header('location: index.php?page=news'));
    }
    $category_id = ($_GET['category_id'] * 1);

    // denne fil er afhængig af at have en nyheds id i URL
    // findes den ikke, så returneres brugeren til nyheds list
    if ( !isset($_GET['news_id']))
    {
        die(header('location: index.php?page=news&category_id='.$category_id));
    }
    $news_id = ($_GET['news_id'] * 1);

    $query = "DELETE FROM news WHERE news_id = $news_id";
    // or die er fjernet og istedet udskrives fejl længere nede
    if (mysqli_query($database_link, $query))
    {
        // hvis det lykkes at slette nyheden fra databsen,
        // så indlæses kategoriens nyheds liste igen
        $_SESSION['message'] .= 'Nyheden blev slettet<br />';
        update_rrs($category_id);
        die(header('location: index.php?page=news&category_id='.$category_id));
    }
    else
    {
        // istedet for at afbryde alt og udskrive fejl ved mysqli_query
        // så udskrives fejlen her.
        // Bonus point for at løse problemet, så fejlen ikke opstår!
        echo format_error_message(mysqli_error($database_link), $query, __LINE__, __FILE__);
    }
?>

