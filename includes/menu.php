<?php
    // denne fil må ikke kunne indlæses direkte, så hvis der ikke findes et
    // databaselink, sendes brugeren til forsiden
    if ( !isset($database_link))
    {
        die(header('location: ../index.php'));
    }

    // åben den ul som menuen ligger inden i
    echo '<ul class="nav nav-pills">';

    // link til forsiden
    $active = ($page_frontend == 'frontpage.php' ? $active = ' class="active"' : '');
    echo '<li'.$active.'><a href="index.php?page=frontpage">Forside</a></li>';

    // link til kontakt siden
    $active = ($page_frontend == 'contact.php' ? $active = ' class="active"' : '');
    echo '<li'.$active.'><a href="index.php?page=contact">Kontakt</a></li>';

    // link til hver af kategorierne
    $query = "  SELECT category_id, category_title
                FROM categories
                ORDER BY category_title ASC";
    $cate_name="";
    $result = mysqli_query($database_link, $query) or if_sql_error_then_die(mysqli_error($database_link), __LINE__, __FILE__, $query);
    while ($row = mysqli_fetch_assoc($result))
    {
        $active = (isset($_GET['category_id']) && $_GET['category_id'] == $row['category_id'] ? ' class="active"' : '');
        if($active!="") $cate_name=$row['category_title'];
        echo '<li'.$active.'><a href="index.php?page=categories&amp;category_id='.$row['category_id'].'">'.$row['category_title'].'</a></li>';
    }

    // link til login
    if (isset($_SESSION['user']))
    {
        // vis et logud link, hvis brugeren er logget på.
        echo '<li><a href="index.php?page=login&amp;action=logout" onclick="return confirm(\'Er du sikker på du vil logge af?\')">Logud <i class="icon-unlock"></i></a></li>';
        // hvis brugeren har rettighed på 10 eller derover,
        // så vises linket til administrationen
        if ($_SESSION['user']['role_access'] >= 10)
        {
            echo '<li><a href="admin/index.php">Administration <i class="icon-cogs"></i></a></li>';
        }
    }
    else
    {
        // vis login linket når brugeren ikke er logget på
        $active = ($page_frontend == 'login.php' ? ' class="active"' : '');
        echo '<li'.$active.'><a href="index.php?page=login">Login <i class="icon-lock"></i></a></li>';
    }

    // her lukkes den ul, som menuen ligger inden i
    echo '</ul>';
?>
