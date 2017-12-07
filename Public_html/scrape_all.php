<?php 
require_once 'simple_html_dom.php';
require_once 'functions.php';
require_once 'dbconnect.php';
ini_set('max_execution_time', 10000);
ob_start();
if(!isset($_SESSION)) { 
  session_start(); 
} 
for ($page = 1; $page <= 50; $page++) {
    $url = 'https://www.mangaupdates.com/series.html?page=' . $page . '&orderby=rating&perpage=100';
    $data = get_remote_data($url);
    $html = str_get_html($data);
    // Find all <td> in <table> which class=text pad col4 
    $table = $html->find('.series_rows_table')[0];
    $URL = array();
    foreach($table->find('tr') as $row) {
        $rowScore = array();
        $rowName = array();
        $cell = $row->find('td.col4');
        if(!empty($cell)) {
            $rowScore[] = $cell[0]->innertext;
            $mu_score = strip_tags($rowScore[0]);                      //Manga score from MangaUpdates
            $name_cell = $row->find('td.col1');
            $rowName[] = $name_cell[0]->innertext;
            $plainName = strip_tags($rowName[0]);       //Manga name as shown in MangaUpdates
            $mu_id = intval(substr($rowName[0], 53, stripos($rowName[0], 'alt') - 55));
            if(stripos($plainName, "(Novel)") !== false || stripos($plainName, "dj -") !== false) {
                continue;
            }
            //Check if the current manga is in the database
            $query = "SELECT * FROM mangas WHERE mu_name='$plainName'";
            echo $query;
            $result = mysqli_query($_SESSION['conn'], $query);
            $count = mysqli_num_rows($result);
            echo ' Count: ' . $count . '<br />';
            
            //If it doesn't
            if ($count == 0) {
              $username = "leonidagarth24";
              $password = "nBFgcZL1ASwl";
              $name = str_replace(" - ", ": ", $plainName);
              $remote_url = 'https://myanimelist.net/api/manga/search.xml?q=' . rawurlencode($name);
              // Create a stream
              $opts = array(
                'http'=>array(
                  'method'=>"GET",
                  'header' => "Authorization: Basic " . base64_encode("$username:$password")                 
                )
              );
              $context = stream_context_create($opts);
              $stream = fopen($remote_url, 'r', false, $context);
              $url_metadata = stream_get_meta_data($stream);

              if (substr($url_metadata['wrapper_data'][0], 9, 3) == "204") {        //Check for Error 204: No Content Error
                  echo '<b>Manga not found with MAL API</b><br />';
                  continue;
              }

              // Open the file using the HTTP headers set above
              $file = file_get_contents($remote_url, false, $context);
              // Convert xml to array
              $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
              $json = json_encode($xml);
              $array = json_decode($json,TRUE);
              $manga = "";
              if (isset($array['entry'][0])) {
                $manga = $array['entry'][0];
              } else {
                $manga = $array['entry'];
              }
              $plainName = mysqli_real_escape_string($_SESSION['conn'], $plainName);
              $id = $manga['id'];
              $name = mysqli_real_escape_string($_SESSION['conn'], $manga['title']);
              $score = $manga['score'];
              if (!empty($manga['english'])) { 
                if (is_array($manga['english'])) {
                  $alt_title = implode(";", $manga['english']) . "; ";
                } else {
                  $alt_title = $manga['english'] . "; ";
                }
              }
              if (!empty($manga['synonyms'])) { 
                if (is_array($manga['synonyms'])) {
                  $alt_title = $alt_title . implode(";", $manga['synonyms']);
                } else {
                  $alt_title = $alt_title . $manga['synonyms'];
                }
              }
              $alt_title = mysqli_real_escape_string($_SESSION['conn'], $alt_title);
              $img = $manga['image'];
              $synop = mysqli_real_escape_string($_SESSION['conn'], $manga['synopsis']);
              $vol = $manga['volumes'];
              $chap = $manga['chapters'];
              $status = $manga['status'];
              $start = $manga['start_date'];
              $finish = $manga['end_date'];
             
              //Insert the manga into the database
              $que = "INSERT INTO mangas(mal_id,mu_id,mal_name,mu_name,alt_title,mal_score,mu_score,img,synop,vol, chap, status, start, finish) VALUES('$id','$mu_id','$name','$plainName','$alt_title','$score','$mu_score','$img','$synop','$vol','$chap','$status','$start','$finish')";
              $res = mysqli_query($_SESSION['conn'], $que);
              echo $que;
              if ($res)
                echo ' <b>Query Success</b><br />';
              else 
                echo ' <b>Query Failed</b> ' . mysqli_error($_SESSION['conn']) . '<br />';
            } /*else if ($count == 1) {
                $que = "UPDATE mangas SET mu_id='$mu_id', mu_score='$mu_score', mal_name='$plainName' WHERE name='$plainName'";
                $res = mysqli_query($_SESSION['conn'], $que);
                echo $que;
                if ($res)
                  echo ' <b>Query Success</b><br />';
                else 
                  echo ' <b>Query Failed</b><br />';
            }*/
        }
    }
}
ob_end_flush();
?>