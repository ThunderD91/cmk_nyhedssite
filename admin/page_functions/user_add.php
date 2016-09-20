<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=users'));
    }

    // her oprettes de variabler der benyttes til at oprette en bruger
    // de er tomme til at starte med.
    $user_name = '';
    $user_email = '';
    $role_id = 1;

    // hvis der er trykket på gem knappen, så er der data der skal håndteres
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
        else if ( !filter_var($user_email, FILTER_VALIDATE_EMAIL))
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Emailen er ikke gyldig</p>';
        }

        if ($role_id < 0)
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Vælg hvilken rolle brugeren skal have</p>';
        }

        // der skal være skrevet i begge kodeords felter
        if ($user_password == '' || $user_password_repeat == '')
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">Udfyld Kodeord</p>';
        }
        // og de to kodeord skal være ens
        else if ($user_password != $user_password_repeat)
        {
            $form_ok = false;
            echo '<p class="alert alert-danger">De to kodeord er ikke ens</p>';
        }

        // hvis alle felterne er i orden, så indsættes der i databasen
        if ($form_ok)
        {
            $user_password=password_hash($user_password, PASSWORD_DEFAULT);
            $query = "
				INSERT INTO users 
					(user_name, user_email, user_password, fk_roles_id) 
				VALUES 
					('$user_name','$user_email', '$user_password','$role_id')";
            $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
            // hvis det lykkes at indsætte i databasen,
            // så genindlæs kategori liste
            if ($result)
            {
                $_SESSION['message'] .= 'Brugeren blev oprettet<br />';
                die(header('location: index.php?page=users'));
            }
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
			<label for="user_password">Kodeord</label>
			<input type="password" class="form-control" name="user_password" id="user_password" placeholder="Kodeord" value=""  required>
		</div>
		<div class="form-group">
			<label for="user_password_repeat">Gentag Kodeord</label>
			<input type="password" class="form-control" name="user_password_repeat" id="user_password_repeat" placeholder="Gentag Kodeord" value="" required>
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
                            echo '<option value="'.$row['role_id'].'">'.$row['role_title'].'</option>';
                        }
                    }
				?>
			</select>
		</div>
		<input type="submit" class="btn btn-success" name="user_submit" value="Gem" />
		<a href="index.php?page=users" class="btn btn-default" onclick="return confirm('Er du sikker på du vil annullere?')">Annuller</a>
	</form>
</div>