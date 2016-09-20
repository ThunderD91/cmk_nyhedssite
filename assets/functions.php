<?php
    function update_rrs($category_id){
        global	$database_link;
        $dom=new DOMDocument('1.0', 'utf-8');
        $dom->formatOutput=true;
        $rss=$dom->createElement('rss');
        $rss->setAttribute('version', '2.0');
        //	her	skrives	alt	det	kode	som	mangler,
        $query	 ="SELECT * FROM categories WHERE category_id=".$category_id;
        $category=mysqli_query($database_link,$query)	or	die(mysqli_error($database_link));
        $cate_res=mysqli_fetch_assoc($category);

        $channel=$dom->createElement('channel');
        $channel->appendChild($dom->createElement('title',$cate_res['category_title']));
        $channel->appendChild($dom->createElement('description',$cate_res['category_description']));
        $channel->appendChild($dom->createElement('link',htmlspecialchars('http://localhost/hoved_p2/nco_cmk_php_nyhedssite/index.php?page=categories&category_id='.$category_id)));
        $rss->appendChild($channel);

        $query	 ="SELECT * FROM news WHERE fk_categories_id=".$category_id;
        $news	 =mysqli_query($database_link,$query)	or	die(mysqli_error($database_link));

        while($row	=	mysqli_fetch_assoc($news)) {
            $item	=	$dom->createElement('item');
            $item->appendChild($dom->createElement('title',	$row['news_title']));
            $item->appendChild($dom->createElement('link',	htmlspecialchars('http://localhost/hoved_p2/nco_cmk_php_nyhedssite/index.php?page=news&category_id='.$category_id.'&news_id='.$row['news_id'])));
            $item->appendChild($dom->createElement('guid',	$row['news_title'].' - '.$row['news_id']));
            $item->appendChild($dom->createElement('description',	$row['news_content']));

            $channel->appendChild($item);
        }
        $rss_feed_name=slugify($cate_res['category_title']).'.xml';
        //	for	at	kunne	lave	et	RSS	feed
        $dom->appendChild($rss);
        $dom->save('../feeds/'.$rss_feed_name);
    }
    function delete_rrs($category_id){
        global	$database_link;
        $query	 ="SELECT category_title FROM categories WHERE category_id=".$category_id;
        $category=mysqli_query($database_link,$query)	or	die(mysqli_error($database_link));
        $cate_res=mysqli_fetch_assoc($category);

        $rss_feed_name=slugify($cate_res['category_title']).'.xml';

        unlink('../feeds/'.$rss_feed_name);
    }
    function slugify($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /*
     * Funktion til at afbryde udførslen af siden,
     * og udskrive brugbare SQL fejlbeskeder.
     * Kræver at der medsendes __LINE__ og __FILE__
     * som er nogle særlige PHP konstanter, der indeholder
     * det linje-nummer som __LINE__ står på, samt det filnavn
     * som __FILE__ findes i.
     */
    function if_sql_error_then_die($error_message, $query, $line_number, $file_name)
    {
        die(format_error_message($error_message, $query, $line_number, $file_name));
    }

    /*
     * Funktion til at udskrive brugbare SQL fejlbeskeder.
     * Kræver at der medsendes __LINE__ og __FILE__
     * som er nogle særlige PHP konstanter, der indeholder
     * det linje-nummer som __LINE__ står på, samt det filnavn
     * som __FILE__ findes i.
     */
    function format_error_message($error_message, $query, $line_number, $file_name)
    {
        return '
            <div class="alert alert-danger">
                <strong>SQL Fejl:</strong> '.$error_message.'<br />
                <strong>Linje:</strong> '.$line_number.'<br />
                <strong>Fil:</strong> '.$file_name.'<br />
                <pre>'.preg_replace('/\s\s+/', ' ', nl2br($query)).'</pre>
            </div>';

    }

    // fiks funktion til at udskrive et enkelt array pænt formatteret
    // og med en titel
    function print_array($array, $title = '')
    {
        // hvis arrayet ikke er tomt, udskrives det i et html <pre> tag
        if (sizeof($array) > 0)
        {
            echo '<pre>';
            // hvis titel variablen ikke er tom, udskrives titlen i mellem []
            // udelukkende for at det ser pænt ud
            if ($title != '')
            {
                echo '['.$title.'] => ';
            }
            // her udskrives arrayets data
            print_r($array);
            echo '</pre>';
        }
        else
        {
            // hvis arryet er tomt, men titlen ikke er tom
            // så udskrives en
            if ($title != '')
            {
                echo '<pre>['.$title.'] => Empty</pre>';
            }
        }
    }

    // fiks lille funktion til at udskrive en masse debug information
    function print_debug_info()
    {
        echo '
            <section class="container" style="margin-top:40px;">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4>PHP SYSTEM ARRAY DEBUGGING INFORMATION...</h4>
                        </div>
                        <div class="panel-body">';

        if (sizeof($_GET) > 0)
        {
            print_array($_GET, 'GET');
        }
        if (sizeof($_POST) > 0)
        {
            print_array($_POST, 'POST');
        }
        if (sizeof($_SESSION) > 0)
        {
            print_array($_SESSION, 'SESSION');
        }
        if (sizeof($_FILES) > 0)
        {
            print_array($_FILES, 'FILES');
        }
        /*
         if (sizeof($_COOKIE) > 0)
         {
         print_array($_COOKIE, 'COOKIE');
         }
         if (sizeof($_REQUEST) > 0)
         {
         print_array($_REQUEST, 'REQUEST');
         }
         if (sizeof($_ENV) > 0)
         {
         print_array($_ENV, 'ENV');
         }
         if (sizeof($_SERVER) > 0)
         {
         print_array($_SERVER, 'SERVER');
         }
         */
        echo '
                        </div>
                    </div>
                </div>
            </section>';
    }
?>