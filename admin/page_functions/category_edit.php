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
    $category_id = ($_GET['category_id'] * 1);

    // her oprettes de variabler der benyttes til at redigere  en kategori
    // de er tomme til at starte med.
    $category_title = '';
    $category_description = '';

    // hvis der er trykket på gem knappen, så skal der opdateres
    if (isset($_POST['category_submit']))
    {
        // gå ud fra formen er udfyldt korrekt
        $form_ok = true;

        // hent værdier fra formularen, husk at 'escape'
        $category_title = mysqli_real_escape_string($database_link, $_POST['category_title']);
        $category_description = mysqli_real_escape_string($database_link, $_POST['category_description']);

        // valider om felterne opfylder de krav der måtte være
        // udskriv en fejl, hvis et af felterne fejler
        // og sæt $form_ok variablen til false
        if ($category_title == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-error">Udfyld titel</p>';
        }
        if ($category_description == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-error">Udfyld beskrivelse</p>';
        }

        // hvis alle felterne er i orden, så opdateres databasen
        if ($form_ok)
        {
            $query = "
            	UPDATE categories SET
            		category_title='$category_title'
            		, category_description = '$category_description'
				WHERE 
					category_id = $category_id";
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            // hvis det lykkes at indsætte i databasen, så genindlæs
            // kategori liste
            if ($result)
            {
                update_rrs($category_id);
                $_SESSION['message'] .= 'Kategorien blev opdateret<br />';
                die(header('location: index.php?page=categories'));
            }
        }
    }
    else
    {
        // hvis der ikke er trykket på gem knappen,
        // så hentes categori data ud af databasen,
        // og puttes i de variabler der blev oprettet tidligere
        $query = "SELECT category_title, category_description FROM categories WHERE category_id = $category_id";
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
        if ($row = mysqli_fetch_assoc($result))
        {
            $category_title = $row['category_title'];
            $category_description = $row['category_description'];
        }
    }
?>

<div class="col-lg-6">
	<form method="post" role="form">
		<div class="form-group">
			<label for="category_title">Kategori Titel</label>
			<input type="text" class="form-control" name="category_title" id="category_title" placeholder="Kategori Titel" value="<?php echo $category_title; ?>" maxlength="32" required>
		</div>
		<div class="form-group">
			<label for="category_description">Beskrivelse</label>
			<input type="text" class="form-control" name="category_description" id="category_description" placeholder="Beskrivelse" value="<?php echo $category_description; ?>" maxlength="200" />
		</div>
		<input type="submit" class="btn btn-success" name="category_submit" value="Gem" />
		<a href="index.php?page=categories" class="btn btn-default" onclick="return confirm('Er du sikker på du vil annullere?')">Annuller</a>
	</form>
</div>
