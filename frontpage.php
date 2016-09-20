<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php'));
    }

    // hent de fem seneste nyheder lige gyldigt hvilken kategori de hører til
    $query = "  SELECT news_id, news_title, news_content, news_postdate, category_id, category_title, user_name 
	            FROM news
	            INNER JOIN categories ON categories.category_id = news.fk_categories_id
	            INNER JOIN users ON users.user_id = news.fk_users_id
	            ORDER BY news_postdate DESC
	            LIMIT 5";
    $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
    if (mysqli_num_rows($result) <= 0)
    {
        // hvis der ikke er nogen nyheder fra databasen, udskrives en besked
        echo '  <p class="alert alert-info">Der er ingen nyheder at vise...</p>';
    }
    else
    {
        // når der er mindst 1 nyhed, så udskrives der.
        while ($row = mysqli_fetch_assoc($result))
        {
            $news_id = $row['news_id'];
            $news_title = $row['news_title'];
            // nyhedens indhold kommer til at bestå af HTML fra CKeditoren
            // derfor stippes al HTML med php-funktionen strip_tags
            // derefter klippes indholdet ned til 250 tegn.
            $news_content = substr(strip_tags($row['news_content']), 0, 247).'...';
            // datoen hentes ud af databasen, og udskrives på dansk dette
            // virker fordi setlocale() er sat til 'danish, øverst på
            // index.php
            $news_postdate = strftime('%d. %B %Y - %H:%M', strtotime($row['news_postdate']));
            $user_name = $row['user_name'];
            $category_id = $row['category_id'];
            $category_title = $row['category_title'];
            echo '
            		<section class="news_category">
                        <h3>'.$news_title.'</h3>
                        <p><a href="index.php?page=news&amp;category_id='.$category_id.'&amp;news_id='.$news_id.'">'.$news_content.'</a></p>
                        <em>af: '.$user_name.', i kategorien: '.$category_title.', den. '.$news_postdate.'</em><hr />
                    </section>';
        }
    }
?>