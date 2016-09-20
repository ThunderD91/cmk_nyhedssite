<?php
    // denne fil må ikke kunne indlæses direkte, så hvis der ikke findes et
    // databaselink, sendes brugeren til forsiden
    if ( !isset($database_link))
    {
        die(header('location: index.php'));
    }

    // start menuen med en overskrift
    echo '<ul class="nav nav-pills nav-stacked">';
    echo '<li><h2>Administration</h2></li>';

    // vis kun administrations links, hvis brugeren har rettighed
    if ($_SESSION['user']['role_access'] > 10)
    {
        // link til admin forsiden
        $active = ($page_backend == 'backend.php' ? ' class="active"' : '');
        echo '<li'.$active.'><a href="index.php">Admin</a></li>';

        // link til bruger admin siden
        $active = ($page_backend == 'users.php' ? ' class="active"' : '');
        echo '<li'.$active.'><a href="index.php?page=users">Brugere</a></li>';

        // link til kategori admin siden
        $active = ($page_backend == 'categories.php' ? ' class="active"' : '');
        echo '<li'.$active.'><a href="index.php?page=categories">Kategorier</a></li>';

        // link til redaktør admin
        $active = ($page_backend == 'editors.php' ? ' class="active"' : '');
        echo '<li'.$active.'><a href="index.php?page=editors">Redaktører</a></li>';
    }

    // link til logud
    echo '<li ><a href="../index.php?page=login&amp;action=logout" onclick="return confirm(\'Er du sikker på du vil logge af?\')">Log af <i class="icon-unlock"></i></a></li>';

    // link til frontend
    echo '<li><a href="../index.php" target="_blank">Vis Frontend <i class="icon-share-alt"></i></a></li>';

    // luk <ul> elementet
    echo '</ul>';

    // TODO:	din opgave er at lave det sådan at hver enkelt redaktør
    // 			kun har adgang til de kategorier, som brugeren er sat til at
    // 			være redaktør for.
    // udskriv links til at administrere hver enkelt nyheds kategori . . . .
    if ($_SESSION['user']['role_access'] >= 10)
    {
        echo '<ul class="nav nav-pills nav-stacked">';
        echo '<li><h2>Nyheds Kategori</h2></li>';

        $join=$_SESSION['user']['role_access'] == 10 ? " INNER JOIN category_editors ON category_id=fk_categories_id AND fk_users_id=".$_SESSION['user']['user_id']." " : "";

        $query = "  SELECT category_id, category_title
					FROM categories".$join."
					ORDER BY category_title ASC";
        $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), $query, __LINE__, __FILE__);
        while ($category = mysqli_fetch_assoc($result))
        {
            // hvis vi er på news siden, og der står en kategori id i url, og den
            // kategori er magen til den kategori id der udskrives lige nu sættes
            // menupunktet til aktiv.
            $active = ($page_backend == 'news.php' && isset($_GET['category_id']) && $_GET['category_id'] == $category['category_id'] ? ' class="active"' : '');
            echo '<li'.$active.'><a href="index.php?page=news&amp;category_id='.$category['category_id'].'">'.$category['category_title'].'</a></li>';
        }
        echo '</ul><br />';
    }
?>

