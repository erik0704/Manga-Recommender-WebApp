<?php

function get_top_recommendation($topGenres) {
    $names = array();
    $url = 'https://www.mangaupdates.com/series.html?perpage=50&genre=' . rawurlencode($topGenres) . '&orderby=rating';
    require_once 'simple_html_dom.php';
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
            $score = $rowScore[0];
            $name_cell = $row->find('td.col1');
            $rowName[] = $name_cell[0]->innertext;
            $plainName = strip_tags($rowName[0]);
            if(stripos($plainName, "(Novel)") !== false || stripos($plainName, " dj -") !== false) {
                continue;
            }
            $names[] = $plainName;       
            /*$seriesURL = substr($rowName[0], 9, stripos($rowName[0], 'alt') - 11);
            $seriesPage = file_get_html($seriesURL);
            $pageTable = $seriesPage->find('.sMember');
            $temp = $pageTable[1]->children;
            $temp = $temp[1]->find('img');
            $seriesIMG = $temp[0]->attr['src'];
            echo "<img src='" . $seriesIMG . "'>";*/
        }
    }
    return $names;
}

function myanimelist_api($manga_name, $mal_id = null) {
  $username = "leonidagarth24";
  $password = "nBFgcZL1ASwl";
  $name = str_replace(" - ", ": ", $manga_name);
  $name = str_replace("-", "", $name);
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
  if (substr($url_metadata['wrapper_data'][0], 9, 3) == "204") {
      return "Error!";
  }
  // Open the file using the HTTP headers set above
  $file = file_get_contents($remote_url, false, $context);
  // Convert xml to array
  $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);

  if ($array['entry'][0] === null) {
    return $array['entry'];
  } else {
    if ($mal_id == null) {
      return $array['entry'][0]; 
    } else {
      for ($i = 0; true; $i++) {
        if ($array['entry'][$i]['id'] == $mal_id) {
          return $array['entry'][$i];
        }
      }
    }
  }
}
function myanimelist_api_get_all($searchString) {
  $username = "leonidagarth24";
  $password = "nBFgcZL1ASwl";
  $remote_url = 'https://myanimelist.net/api/manga/search.xml?q=' . rawurlencode($searchString);
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
  if (substr($url_metadata['wrapper_data'][0], 9, 3) == "204") {
      return "Error!";
  }
  // Open the file using the HTTP headers set above
  $file = file_get_contents($remote_url, false, $context);
  // Convert xml to array
  $xml = simplexml_load_string($file, "SimpleXMLElement", LIBXML_NOCDATA);
  $json = json_encode($xml);
  $array = json_decode($json,TRUE);

  if ($array['entry'][0] === null) {
    return array($array['entry']);
  } else {
    return $array['entry'];
  }
}

function save_recommendations($user, $recommendations) {
    if( !isset($user) ){
        return "Error! User not set";
    }
    $sql = "UPDATE users SET recList='$recommendations' WHERE userName='$user'";
    mysqli_query($_SESSION['conn'], $sql);
}
function manga_genre_search($genre_string) {
    // return array of string
    include '/unirest-php-master/src/Unirest.php';
    Unirest\Request::verifyPeer(false);
    $input = '["' . str_replace(' ', '","', strtolower($genre_string)) . '"]';
    $url = 'https://doodle-manga-scraper.p.mashape.com/mangareader.net/search' .
           '?g=' . rawurlencode($input);
    $response = Unirest\Request::get($url,
      $header = array(
        "X-Mashape-Key" => "T7TWaLHGy9mshbC7l7HrGH3ajphHp1ItNuVjsnwRUILttgPjcS",
        "Accept" => "text/plain"
      ), $parameters = null
    );

    $array = $response->body;
    $result = array();
    foreach ($array as $key) {
        $result[] = $key->name;
    }
    return $result;
}

function array_contain_string($array, $str) {
    foreach ($array as $string) {
        if ($string == $str) {
            return true;
        }
    }
    return false;
}
function top_5_score($name_array) { //argument from manga_genre_search
    $result = array();
    $count = 0;
    // $score_list = get_data('score');
    $name_list = get_data('name');
    for($i = 0; $i < 5000; $i++) {
        $str = $name_list[$i];
        if (array_contain_string($name_array, $str)) {
            $result[] = $str;
            $count++;
        }
        if ($count >= 5) {
            return $result;
        }
    }
}

function get_data($input) { //input is either 'score' or 'name'
    require_once '/login-registration-php-new/dbconnect.php';
    $a = array();
    if ($input == 'score') {
        $res = mysqli_query($_SESSION['conn'], "SELECT score FROM mangas");
    } else {
        $res = mysqli_query($_SESSION['conn'], "SELECT name FROM mangas");
    }
    for($i = 0; $i < 5000; $i++) {
        if($input == 'score') {
            $row_sc = mysqli_fetch_array($res);
            $a[] =  (double) $row_sc['score'];
        } else if ($input == 'name') {
            $row_n = mysqli_fetch_array($res);
            $a[] =  $row_n['name'];
        }
    }
    return $a;
}
function manga_entry($manga_name, $mu_id = null, $mu_score = null) { // save manga info if new, return id of existed/just inserted entry
    $query = "SELECT id FROM mangas WHERE mu_name='$manga_name'";
    echo $query;
    $result = mysqli_query($_SESSION['conn'], $query);
    $count = mysqli_num_rows($result);
    if($count == 0){
      $array = myanimelist_api($manga_name);
      if ($array == "Error!") {
        return 0;
      }
      $manga_name = mysqli_real_escape_string($_SESSION['conn'], $manga_name);
      $id = $array['id'];
      $name = mysqli_real_escape_string($_SESSION['conn'], $array['title']);
      $score = $array['score'];
      if (!empty($array['english'])) { 
        if (is_array($array['english'])) {
          $alt_title = implode(";", $array['english']) . "; ";
        } else {
          $alt_title = $array['english'] . "; ";
        }
      }
      if (!empty($array['synonyms'])) { 
        if (is_array($array['synonyms'])) {
          $alt_title = $alt_title . implode(";", $array['synonyms']);
        } else {
          $alt_title = $alt_title . $array['synonyms'];
        }
      }
      $alt_title = mysqli_real_escape_string($_SESSION['conn'], $alt_title);
      $img = $array['image'];
      $synop = mysqli_real_escape_string($_SESSION['conn'], $array['synopsis']);
      $vol = $array['volumes'];
      $chap = $array['chapters'];
      $status = $array['status'];
      $start = $array['start_date'];
      $finish = $array['end_date'];
      $query = "";
      if ($mu_id === null)
        $query = "INSERT INTO mangas(mal_id,mal_name,mu_name,alt_title,mal_score,img,synop,vol, chap, status, start, finish) VALUES($id,'$name','$manga_name','$alt_title','$score','$img','$synop','$vol','$chap','$status','$start','$finish')";
      else 
        $query = "INSERT INTO mangas(mal_id,mu_id,mal_name,mu_name,alt_title,mal_score,mu_score,img,synop,vol, chap, status, start, finish) VALUES($id,$mu_id,'$name','$manga_name','$alt_title','$score','$mu_score','$img','$synop','$vol','$chap','$status','$start','$finish')";
      echo $query;
      $res = mysqli_query($_SESSION['conn'], $query);
      /*if ($res) {
          $errTyp = "success";
          $errMSG = "success add new manga entry";
          unset($pic);
      } else {
          $errTyp = "danger";
          $errMSG = "Something went wrong, try again later..."; 
      }*/
      return mysqli_insert_id($_SESSION['conn']); 
    }
    
    else {
      $res = mysqli_fetch_array($result);
      return $res['id'];
    }
}
function getMangaById($id) {
  $query = "SELECT * FROM mangas WHERE id='$id'";
  $res = mysqli_query($_SESSION['conn'], $query);
  $manga = mysqli_fetch_array($res);
  return $manga;
}
function getMangaByName($name) {
  $query = "SELECT * FROM mangas WHERE mu_name='$name'";
  $res = mysqli_query($_SESSION['conn'], $query);
  $count = mysqli_num_rows($res);
  if ($count == 0) {
    $query = "SELECT * FROM mangas WHERE mal_name='$name'";
    $res = mysqli_query($_SESSION['conn'], $query);
  }
  $manga = mysqli_fetch_array($res);
  return $manga;
}
function getReviewById($id) {
  $query = "SELECT * FROM review WHERE id='$id'";
  $res = mysqli_query($_SESSION['conn'], $query);
  $review = mysqli_fetch_array($res);
  return $review;
}
function getReviewsFromManga($manga_id) {
  $query = "SELECT * FROM review WHERE manga_id='$manga_id'";
  $res = mysqli_query($_SESSION['conn'], $query);
  $reviews = mysqli_fetch_all($res,MYSQLI_ASSOC);
  return $reviews;
}
function convertDate($date) {
  $yyyy = substr($date, 0, 4);
  $mm = substr($date, 5, 2);
  $dd = substr($date, 8, 2);
  if ($dd == "00") $dd = "15";
  $month = "December";
  switch ($mm) {
    case '01': $month = "January,"; break;
    case '02': $month = "February,"; break;
    case '03': $month = "March,"; break;
    case '04': $month = "April,"; break;
    case '05': $month = "May,"; break;
    case '06': $month = "June,"; break;
    case '07': $month = "July,"; break;
    case '08': $month = "August,"; break;
    case '09': $month = "September,"; break;
    case '10': $month = "October,"; break;
    case '11': $month = "November,"; break;
    default: break;
  }
  if ($yyyy == "0000") {
    return "??";
  } else {
    return $dd . " " . $month . " " . $yyyy;
  }
}
function addManga($username, $mangaID) {
  if ($username == null || $username == "undefined") {
    return "You have not logged in";
  } else {
    $query = "SELECT readManga FROM users WHERE userName='$username'"; 
    $res = mysqli_query($_SESSION['conn'], $query);
    $row = mysqli_fetch_array($res);
    $oldReadList = $row['readManga'];
    $newReadList = "";
    if ($oldReadList == null) {
      $newReadList = "$mangaID";
    } else {
      $array = explode("_", $oldReadList);
      if (in_array("$mangaID", $array)) {
        return "You have already read this manga";
      } else {
        $array[] = "$mangaID";
        sort($array);
        $newReadList = implode("_", $array);
      }
    }
    $query = "UPDATE users SET readManga='$newReadList' WHERE userName='$username'"; 
    //echo $query . "<br />";
    $res = mysqli_query($_SESSION['conn'], $query);
    return "You have added this manga to your manga list";
  }
}