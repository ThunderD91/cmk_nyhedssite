<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=users'));
    }

    // denne side er afhængig af at have en user id i URL
    // findes den ikke, sendes vi tilbage til brugerlisten
    if ( !isset($_GET['user_id']))
    {
        die(header('location: index.php?page=users'));
    }
    $user_id = ($_GET['user_id'] * 1);

    // her oprettes de variabler der benyttes til at oprette en bruger
    // de er tomme til at starte med.
    $user_name = '';
    $user_email = '';
    $role_id = 1;

    // når der er trykket på gem knappen, så er der data som skal håndteres
    if (isset($_POST['user_submit']))
    {
        // gå ud fra formen er udfyldt korrekt
        $form_ok = true;

        // hent værdier fra formularen, husk at 'escape'
        $user_name = mysqli_real_escape_string($database_link, $_POST['user_name']);
        $user_email = mysqli_real_escape_string($database_link, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($database_link, $_POST['user_password']);
        $user_password_repeat = mysqli_real_escape_string($database_link, $_POST['user_password_repeat']);
        $role_id = ($_POST['role_id'] * 1);

        // valider om felterne opfylder de krav der måtte være
        // udskriv en fejl, hvis et af felterne fejler
        // og sæt $form_ok variablen til false
        if ($user_name == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Udfyld Navn</p>';
        }
        if ($user_email == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Udfyld Email</p>';
        }
        else
        if ( !filter_var($user_email, FILTER_VALIDATE_EMAIL))
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Emailen er ikke gyldig</p>';
        }
        if ($role_id < 0)
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Vælg hvilken rolle brugeren skal have</p>';
        }

        // kodeordet skal kun tjekkes, hvis et af felterne er udfyldt
        // hvis ingen er udfyldt, så betyder det at kodeordet IKKE ændres
        if ($user_password != '' || $user_password_repeat != '')
        {
            // hvis mindst et af felterne er udfyldt
            // tjekkes om de to felter er ens...
            if ($user_password != $user_password_repeat)
            {
                $form_ok = false;
                echo '<p class="alert alert-danger">De to kodeord er ikke ens</p>';
            }
        }

        // hvis alle felterne er i orden, så opdateres databasen
        if ($form_ok)
        {

            $query = "
            	UPDATE 
            		users
        		SET 
            		user_name = '$user_name'
					, user_email = '$user_email'
        			, fk_roles_id = '$role_id'
				WHERE 
					user_id = '$user_id'";
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            // hvis det lykkes at opdatere brugeren, så genindlæs bruger listen
            if ($result)
            {
                $_SESSION['message'] .= 'Brugeren blev opdateret<br />';

                // hvis der er et nyt kodeord, opdaters kodeordet
                // dette kan også ændres så det gøres sammen med resten
                if ($user_password != '')
                {
                    $user_password=password_hash($user_password, PASSWORD_DEFAULT);
                    $query = "UPDATE users SET user_password = '$user_password' WHERE user_id = '$user_id'";
                    $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
                    // hvis det lykkes at opdatere brugeren, så genindlæs bruger
                    // listen
                    if ($result)
                    {
                        // en lille information der tilføjes session beskeden
                        $_SESSION['message'] .= 'Det nye kodeord blev gemt<br />';
                    }
                }
                // genindlæs bruger listen
                die(header('location: index.php?page=users'));
            }
        }
    }
    else
    {
        // hvis der ikke er trykket på gem knappen,
        // så hentes user  data ud af databasen,
        // og puttes i de variabler der blev oprettet tidligere
        $query = "SELECT user_name, user_email, fk_roles_id FROM users WHERE user_id = $user_id";
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
        if ($row = mysqli_fetch_assoc($result))
        {
            $user_name = $row['user_name'];
            $user_email = $row['user_email'];
            $role_id = $row['fk_roles_id'];
        }
    }
?>
<div class="col-lg-6">
    <form method="post" role="form">
        <div class="form-group">
            <label for="user_name">Navn</label>
            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Brugerns Navn" value="<?php echo $user_name; ?>" maxlength="32" required>
        </div>
        <div class="form-group">
            <label for="user_email">Email</label>
            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email" value="<?php echo $user_email; ?>" maxlength="128" required>
        </div>
        <div class="form-group">
            <label for="user_password">Kodeord <em class="label label-default">(kun hvis kodeordet ønskes ændret)</em></label>
            <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Kodeord" value="">
        </div>
        <div class="form-group">
            <label for="user_password_repeat">Gentag Kodeord <em class="label label-default">(kun hvis kodeordet ønskes ændret)</em></label>
            <input type="password" class="form-control" name="user_password_repeat" id="user_password_repeat" placeholder="Gentag Kodeord" value="">
        </div>
        <div class="form-group">
            <label for="role_id">Rolle</label>
            <select class="form-control" name="role_id" id="role_id">
                <option value="0">Vælg Rolle</option>
                <?php
                    $query = "SELECT role_id, role_title FROM roles ORDER BY role_access ASC";
                    $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
                    if (mysqli_num_rows($result) > 0)
                    {
                        while ($row = mysqli_fetch_assoc($result))
                        {
                            $selected = ($role_id == $row['role_id'] ? ' selected="selected"' : '');
                            echo '<option value="'.$row['role_id'].'"'.$selected.'>'.$row['role_title'].'</option>';
                        }
                    }
                ?>
            </select>
        </div>
        <input type="submit" class="btn btn-success" name="user_submit" value="Gem" />
        <a href="index.php?page=users" class="btn btn-default" onclick="return confirm('Er du sikker på du vil annullere?')">Annuller</a>
    </form>
</div>