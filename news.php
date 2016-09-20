<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=news'));
    }

    // hvis der ikke er en news id i URL, så udskrives en besked
    if ( !isset($_GET['news_id']))
    {
        echo '  <p class="alert alert-info">
                    <strong>INFO</strong> Der er ikke valgt nogen nyhed... 
                    <a href="index.php?page=frontpage" class="btn btn-primary">Gå til Forsiden</a>
                </p>';
    }
    else
    {
        // når der ER en news id i URL'en, så hent den nyhed.
        // Husk lige at sikre at id'en er et TAL (ved at gange med 1))
        $query = "  SELECT news.*, user_name 
                    FROM news
                    INNER JOIN users ON user_id = news.fk_users_id 
                    WHERE news_id = ".($_GET['news_id'] * 1);
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);

        // hvis der ikke er noget resultat fra databasen
        // (rækker <= 0) så udskrives en besked
        if (mysqli_num_rows($result) <= 0)
        {
            echo '  <p class="alert alert-info">
                        <strong>INFO</strong> Den ønskede nyhed kunne ikke findes... 
                        <a href="index.php?page=frontpage" class="btn btn-primary">Gå til Forsiden</a>
                    </p>';
        }
        else
        {
            // når der ER rækker fra databasen, så udskriv dem
            $row = mysqli_fetch_assoc($result);
            echo '  <h1>'.$row['news_title'].'</h1>
                    '.$row['news_content'].'<br /><br />
                    <em class="text-muted">Skrevet af: '.$row['user_name'].', den: '.$row['news_postdate'].'</em>';
            // gem titlen i en variabel, så den kan udskrives i krummestien
            $news_title = $row['news_title'];

            // breadcrumbs / krummesti
            // her er det nødvendigt at hente kategoriens titel fra databasen
            // (der kunne sikkert laves noget smart ved at gemme kategorinavnet
            // mens menuen udskrives, for at spare dette SQL kald,
            // bonus for at lave det)
            $query = "  SELECT category_title 
                        FROM categories 
                        WHERE category_id = ".($_GET['category_id'] * 1);
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            $row = mysqli_fetch_assoc($result);
            echo '  <div class="bottom">
                        <ul class="breadcrumb">
                            <li><a href="index.php?page=frontpage">Forside</a></li>
                            <li><a href="index.php?page=categories&amp;category_id='.$_GET['category_id'].'">'.$row['category_title'].'</a></li>
                            <li class="active">'.$news_title.'</li>
                        </ul>
                    </div>';
        }
    }
?>