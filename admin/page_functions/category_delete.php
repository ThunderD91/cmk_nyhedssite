<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=categories'));
    }

    // denne fil er afhængig af at have en kategori id i URL
    // findes den ikke, så returneres brugeren til kategori list
    if ( !isset($_GET['category_id']))
    {
        die(header('location: index.php?page=categories'));
    }

    // her oprettes de variabler der benyttes til at slette en kategori
    // det er kun kategori id'en der er nødvendig
    $category_id = ($_GET['category_id'] * 1);
    delete_rrs($category_id);
    $query = "DELETE FROM categories WHERE category_id = $category_id";
    // or die er fjernet og istedet udskrives fejl længere nede
    if (mysqli_query($database_link, $query))
    {
        // hvis det lykkes at slette kategorien fra databsen,
        // så indlæses kategori liste siden igen
        $_SESSION['message'] .= 'Kategorien blev slettet<br />';
        die(header('location: index.php?page=categories'));
    }
    else
    {
        // istedet for at afbryde alt og udskrive fejl ved mysqli_query
        // så udskrives fejlen her.
        // Bonus point for at løse problemet, så fejlen ikke opstår!
        echo format_error_message(mysqli_error($database_link), $query, __LINE__, __FILE__);
    }
?>

