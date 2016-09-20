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
    // findes den ikke, så returneres brugeren til kategori list
    if ( !isset($_GET['category_id']))
    {
        die(header('location: index.php?page=news'));
    }
    $category_id = ($_GET['category_id'] * 1);

    // her oprettes de variabler der benyttes til at oprette en kategori
    // de er tomme til at starte med.
    $news_title = '';
    $news_content = '';
    $user_id = $_SESSION['user']['user_id'];

    // hvis der er trykket på gem knappen, så er der data der skal håndteres
    if (isset($_POST['news_submit']))
    {
        // gå ud fra formen er udfyldt korrekt
        $form_ok = true;

        // hent værdier fra formularen, husk at 'escape'
        $news_title = mysqli_real_escape_string($database_link, $_POST['news_title']);
        $news_content = mysqli_real_escape_string($database_link, $_POST['news_content']);

        // valider om felterne opfylder de krav der måtte være
        // udskriv en fejl, hvis et af felterne fejler
        // og sæt $form_ok variablen til false
        if ($news_title == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-error">Udfyld titel</p>';
        }
        if ($news_content == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-error">Udfyld nyheds teksten</p>';
        }

        // hvis alle felterne er i orden, så indsættes der i databasen
        if ($form_ok)
        {
            $query = "
				INSERT INTO news 
					(news_title, news_content, news_postdate, fk_users_id, fk_categories_id) 
				VALUES 
					('$news_title','$news_content', NOW(), '$user_id', '$category_id')";
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            // hvis det lykkes at indsætte i databasen,
            // så genindlæs kategoriens nyheds liste
            if ($result)
            {
                $_SESSION['message'] .= 'Nyheden blev oprettet<br />';
                update_rrs($category_id);
                die(header('location: index.php?page=news&category_id='.$category_id));
            }
        }
    }
?>
<div class="col-lg-12">
    <form method="post" role="form">
        <div class="form-group">
            <label for="news_title">Nyheds Titel</label>
            <input type="text" class="form-control" name="news_title" id="news_title" placeholder="Nyheds Titel" value="<?php echo $news_title; ?>" maxlength="64" required>
        </div>
        <div class="form-group ">
            <label for="news_content">Nyheds Tekst</label>
            <textarea class="form-control" name="news_content" id="news_content" placeholder="Nyheds Tekst" rows="10" required><?php echo $news_content; ?></textarea>
        </div>
        <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="form-control" name="category_id" id="category_id">
                <option value="0">Vælg Kategori</option>
                <?php
                    $query = "SELECT category_id, category_title FROM categories ORDER BY category_title ASC";
                    $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
                    if (mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $selected = ($category_id == $row['category_id'] ? ' selected="selected"' : '');
                            echo '<option value="'.$row['fk_categories_id'].'"'.$selected.'>'.$row['category_title'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-success" name="news_submit" value="Gem" />
        <a href="index.php?page=news&amp;category_id=<?php echo $category_id; ?>" class="btn btn-default" onclick="return confirm('Er du sikker på du vil annullere?')">Annuller</a>
    </form>
</div>