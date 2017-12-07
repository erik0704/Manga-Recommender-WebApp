<?php 
if(!isset($_SESSION)) { 
  session_start(); 
} 
ob_start();
require_once 'simple_html_dom.php';
require_once 'functions.php';
require_once 'dbconnect.php';
ini_set('max_execution_time', 10000);

for ($page = 1; $page <= 50; $page++) {
    $url = 'https://www.mangaupdates.com/series.html?page=' . $page . '&orderby=rating&perpage=100&genre=Hentai';
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
            //Check if the current manga is in the database
            $query = "SELECT * FROM mangas WHERE mu_name='$plainName'";
            $result = mysqli_query($_SESSION['conn'], $query);
            $count = mysqli_num_rows($result);

            $id = null;
            $mal_id = null;
            $mal_name = null;
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
                $mal_id = null;
                $mal_name = null;
              } else {
                // Open the file using the HTTP headers set above
                $file = file_get_contents($remote_url, false, $context);
                // Convert xml to array
                $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
                $json = json_encode($xml);
                $array = json_decode($json,TRUE);
                //var_dump($array);
                if (isset($array['entry'][0])) {
                  $mal_id = $array['entry'][0]['id'];
                  $mal_name = $array['entry'][0]['title'];
                } else {
                  $mal_id = $array['entry']['id'];
                  $mal_name = $array['entry']['title'];
                }
              }
            } else if ($count == 1) {
              $manga = mysqli_fetch_array($result);
              $id = $manga['id'];
              $mal_id = $manga['mal_id'];
              $mal_name = mysqli_real_escape_string($_SESSION['conn'], $manga['mal_name']);
            }
            $mu_name = mysqli_real_escape_string($_SESSION['conn'], $plainName);
            $que = '';
            if ($id == null)
              if ($mal_id == null)
                $que = "INSERT INTO blacklist(mu_id,mu_name) VALUES($mu_id,'$mu_name')";
              else
                $que = "INSERT INTO blacklist(mal_id,mu_id,mal_name,mu_name) VALUES($mal_id,$mu_id,'$mal_name','$mu_name')";
            else
              if ($mal_id == null)
                $que = "INSERT INTO blacklist(id,mu_id,mu_name) VALUES($id,$mu_id,'$mu_name')";
              else
                $que = "INSERT INTO blacklist(id,mal_id,mu_id,mal_name,mu_name) VALUES($id,$mal_id,$mu_id,'$mal_name','$mu_name')";
            $res = mysqli_query($_SESSION['conn'], $que);
            echo $que;
            if ($res)
              echo ' <b>Query Success</b><br />';
            else 
              echo ' <b>Query Failed</b> ' . mysqli_error($_SESSION['conn']) . '<br />';
        }
    }
}
ob_end_flush();
?>