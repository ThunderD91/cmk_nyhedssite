<?php
    // denne fil inkluderes fra index.php, så der er allerede hul igennem
    // til database, sessions og al design osv...
    // skulle det ske at nogen prøvede at åbne filen direkte,
    // så indlæses siden korrekt med en header-location
    if ( !isset($database_link))
    {
        die(header('location: index.php?page=login'));
    }

    // default forudfyld værdier til formularen
    $email = "bb@cmk-dynamisk-web.dk";
    $password = "1234";

    // login
    if (isset($_POST['login_submit']))
    {
        // start med at sikre data fra formularen, med en escape_string
        $email = mysqli_real_escape_string($database_link, $_POST['login_email']);
        $password = mysqli_real_escape_string($database_link, $_POST['login_password']);

        $query = "  SELECT user_id, user_name, user_email, role_access, user_password
                    FROM users
                    INNER JOIN roles ON role_id = users.fk_roles_id
                    WHERE user_email = '$email'
                    /*AND user_password = '$password'*/";
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
        // hvis der ikke er EN række i udtrækket, vises en fejlbesked
        if (mysqli_num_rows($result) <> 1)
        {
            echo '<p class="alert alert-danger"><strong>FEJL</strong> Ukendt Email eller Kodeord</p>';
        }
        else
        {
            $user=mysqli_fetch_assoc($result);
            if (password_verify($password, $user['user_password'])){
                // hvis der er EN række, gemmes alt sammen i session['user']
                session_regenerate_id();
                unset($user['user_password']);
                if($user['role_access'] == 10){
                    $query="SELECT fk_categories_id FROM category_editors
                            WHERE fk_users_id=" . $user['user_id'];
                    $acl = mysqli_query($database_link, $query);

                    $acl2=array();
                    foreach($acl as $a){
                        $acl2[]=$a['fk_categories_id'];
                    }
                    $user['acl']=$acl2;
                }
                $_SESSION['user'] = $user;

                // og brugeren sendes til forsiden
                die(header('location: index.php'));
            }else{
                echo '<p class="alert alert-danger"><strong>FEJL</strong> Ukendt Email eller Kodeord</p>';
            }

        }
    }

    // logud
    if (isset($_GET['action']) && $_GET['action'] == 'logout')
    {
        // slet alt i session['user'] og indlæs forsiden
        unset($_SESSION['user']);
        die(header('location: index.php'));
    }
?>

<div class="row">
    <div class="col-5">
        <form class="form-horizontal" method="post">
            <div class="form-group">
                <label for="login_email" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-4">
                    <input type="email" class="form-control" name="login_email" placeholder="Email" value="<?php echo $email ?>"  required autofocus  />
                </div>
            </div>
            <div class="form-group">
                <label for="login_password" class="col-lg-2 control-label">Kodeord</label>
                <div class="col-lg-4">
                    <input type="password" class="form-control" name="login_password" placeholder="Kodeord" value="<?php echo $password ?>" required />
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-offset-2 col-lg-10">
                    <input type="submit" class="btn btn-default" name="login_submit" value="Login">
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row bottom">
    <ul class="breadcrumb">
        <li>
            <a href="index.php?page=frontpage">Forside</a>
        </li>
        <li class="active">
            Login
        </li>
    </ul>
</div>