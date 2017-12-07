<?php 
require_once 'simple_html_dom.php';
require_once 'functions.php';
require_once 'dbconnect.php';
ini_set('max_execution_time', 10);
ob_start();
if(!isset($_SESSION)) { 
  session_start(); 
} 
?>

<!DOCTYPE html>
<html>
<title>Add incompatible manga</title>
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
h4 {
  font-weight: bold;
  margin: 5px;
}
input {
  margin: 5px 15px;
  width: 300px;
}
</style>
<body>
<form method="get" id="add">
  <div>
    <h4>MangaUpdates Name</h4>
    <input type="text" name="mu_name" id="mu_name" placeholder="Enter name as shown on MangaUpdates" required/><br />
    <h4>MyAnimeList Name</h4>
    <input type="text" name="mal_name" id="mal_name" placeholder="Enter name as shown on MyAnimeList" required/><br />
    <h4>MangaUpdates ID</h4>
    <input type="text" name="mu_id" id="mu_id" placeholder="Enter manga's id on MangaUpdates" required/><br />
    <h4>MyAnimeList ID</h4>
    <input type="text" name="mal_id" id="mal_id" placeholder="Enter manga's id on MangaUpdates" required/><br />
    <h4>MangaUpdates Score</h4>
    <input type="text" name="mu_score" id="mu_score" placeholder="Enter manga's score on MangaUpdates" required/><br />
    <input type="submit" value="Add to database" />
  </div>
  <div>
    <?php
    if (isset($_GET['mu_id'])) {
      $mu_name = $_GET['mu_name'];
      $mal_name = $_GET['mal_name'];
      $mu_id =  $_GET['mu_id'];
      $mu_score =  $_GET['mu_score'];
      $mal_id = $_GET['mal_id'];
      $query = "SELECT * FROM mangas WHERE mu_id='$mu_id'";
      $result = mysqli_query($_SESSION['conn'], $query);
      $count = mysqli_num_rows($result);
      if ($count == 0) {
        $query = "SELECT * FROM mangas WHERE mal_id='$mal_id'";
        $result = mysqli_query($_SESSION['conn'], $query);
        $count = mysqli_num_rows($result);
        if ($count == 0) {
          $username = "leonidagarth24";
          $password = "nBFgcZL1ASwl";
          $remote_url = 'https://myanimelist.net/api/manga/search.xml?q=' . rawurlencode($mal_name);
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
            echo 'Manga not found with MAL API. Check the names again.<br />';
            return;
          }

          // Open the file using the HTTP headers set above
          $file = file_get_contents($remote_url, false, $context);
          // Convert xml to array
          $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
          $json = json_encode($xml);
          $array = json_decode($json,TRUE);
          $manga = 0;
          if (!isset($array['entry'][0])) {
            $manga = $array['entry'];
          } else {
            if ($mal_id == null) {
              $manga = $array['entry'][0]; 
            } else {
              for ($i = 0; true; $i++) {
                //echo $array['entry'][$i]['id'] . " == " . $mal_id . "? " . $array['entry'][$i]['id'] == $mal_id;
                if ($array['entry'][$i]['id'] == $mal_id) {
                  $manga = $array['entry'][$i];
                } else if (!isset($array['entry'][$i])) {
                  break;
                }
              }
            }
          }
          $mu_name = mysqli_real_escape_string($_SESSION['conn'], $mu_name);
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
          $que = "INSERT INTO mangas(mal_id,mu_id,mal_name,mu_name,alt_title,mal_score,mu_score,img,synop,vol, chap, status, start, finish) VALUES('$id','$mu_id','$name','$mu_name','$alt_title','$score','$mu_score','$img','$synop','$vol','$chap','$status','$start','$finish')";
          $res = mysqli_query($_SESSION['conn'], $que);
          echo "<b>Query: </b>" . $que . "<br />";
          if ($res)
            echo ' <b>Query Success</b><br />';
          else 
            echo ' <b>Query Failed. </b> ' . mysqli_error($_SESSION['conn']) . '<br />';
        } else {
          echo "Manga is already in database";
        }
      } else {
        echo "Manga is already in database";
      }
    }
    ?>
  </div>
</form>
</body>
</html>

<?php ob_end_flush(); ?>