<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  ini_set('max_execution_time', 30); //60 seconds = 1 minute

  class Genre {
    public $name;
    public $score = 0;
    
    public function __construct($genreName) {
      $this->name = $genreName;
    }
    
    public function increase($x) {
      $this->score += $x;
    }
    public function decrease($x) {
      $this->score -= $x;
    }
  }

  class Category {
    public $name;
    public $inclu = false;
    public $exclu = false;
    
    public function __construct($catName) {
      $this->name = $catName;
    }
    
    public function includ() {
      $this->inclu = true;
      $this->exclu = false;
    }
    public function exclud() {
      $this->exclu = true;
      $this->inclu = false;
    }
  }

  $action        = new Genre("Action");
  $adventure     = new Genre("Adventure");
  $comedy        = new Genre("Comedy");
  $drama         = new Genre("Drama");
  $ecchi         = new Genre("Ecchi");
  $fantasy       = new Genre("Fantasy");
  $historical    = new Genre("Historical");
  $horror        = new Genre("Horror");
  $mystery       = new Genre("Mystery");
  $psychological = new Genre("Psychological");
  $romance       = new Genre("Romance");
  $schoolLife    = new Genre("School Life");
  $scifi         = new Genre("Sci-fi");
  $sliceOfLife   = new Genre("Slice of Life");
  $sports        = new Genre("Sports");
  $supernatural  = new Genre("Supernatural");
  $tragedy       = new Genre("Tragedy");

  $leadCharacter      = new Category("Lead"); $leadCharacter->includ();
  $century            = new Category("21st Century");
  $bloodAndGore       = new Category("Blood and Gore");
  $characterGrowth    = new Category("Character Growth");
  $childhoodFriend    = new Category("Childhood Friend/s");
  $confession         = new Category("Confession/s");
  $firstLove          = new Category("First Love");
  $friendsBecomeLovers= new Category("Friends Become Lovers");
  $friendship         = new Category("Friendship");
  $infidelity         = new Category("Infidelity");
  $loveTriangle       = new Category("Love Triangle/s");
  $magic              = new Category("Magic");
  $monster            = new Category("Monster");
  $pastPlaysABigRole  = new Category("Past Plays a Big Role");
  $revenge            = new Category("Revenge");
  $specialAbility     = new Category("Special Ability/ies");
  $unexpressedFeelings= new Category("Unexpressed Feeling/s");
  $unrequitedLove     = new Category("Unrequited Love");
  $violence           = new Category("Violence");

function add($x) {
  $args = func_get_args();
  foreach ($args as $genre) {
    if (is_int($genre))
      continue;
    $genre->increase($x);
  }
}
function minus($x) {
  $args = func_get_args();
  foreach ($args as $genre) {
    if (is_int($genre))
      continue;
    $genre->decrease($x);
  }
}

  $qn1  = $_POST["qn1-ans"];
  $qn2  = $_POST["qn2-ans"];
  $qn3  = $_POST["qn3-ans"];
  $qn4  = $_POST["qn4-ans"];
  $qn5  = $_POST["qn5-ans"];
  $qn6  = $_POST["qn6-ans"];
  $qn7  = $_POST["qn7-ans"];
  $qn8  = $_POST["qn8-ans"];
  $qn9  = $_POST["qn9-ans"];
  $qn10 = $_POST["qn10-ans"];
  $qn11 = $_POST["qn11-ans"];
  $qn12 = $_POST["qn12-ans"];
  $qn13 = $_POST["qn13-ans"];
  $qn14 = $_POST["qn14-ans"];
  $qn15 = $_POST["qn15-ans"];
  $qn16 = $_POST["qn16-ans"];
  $qn17 = $_POST["qn17-ans"];
  $qn18 = $_POST["qn18-ans"];
  $qn19 = $_POST["qn19-ans"];
  $qn20 = $_POST["qn20-ans"];
  $qn21 = $_POST["qn21-ans"];
  $qn22 = $_POST["qn22-ans"];
  $qn23 = $_POST["qn23-ans"];
  $qn24 = $_POST["qn24-ans"];
  $qn25 = $_POST["qn25-ans"];
  $qn26 = $_POST["qn26-ans"];
  $qn27 = $_POST["qn27-ans"];
  $qn28 = $_POST["qn28-ans"];
  $qn29 = $_POST["qn29-ans"];
  $qn30 = $_POST["qn30-ans"];
  $qn31 = $_POST["qn31-ans"];
  $qn32 = $_POST["qn32-ans"];
  $qn33 = $_POST["qn33-ans"];
  $qn34 = $_POST["qn34-ans"];
  $qn35 = $_POST["qn35-ans"];
  $qn36 = $_POST["qn36-ans"];

  $demo1 = "";
  $demo2 = "";
  $demo3 = "";
  $demo4 = "";
  $demo5 = "";
  switch ($qn1) {
    case "A": add(1,$romance); $demo1 = "Female"; break;
    case "B": add(1,$action,$ecchi); $demo1 = "Male"; break;
    case "C": $demo1 = "Others";
    case "D": $demo1 = "Rather not say";
  }
  switch ($qn2) {
    case "A": $demo2 = "10-"; break;
    case "B": $demo2 = "11-20"; break;
    case "C": $demo2 = "21-30"; break;
    case "D": $demo2 = "31-40"; break;
    case "E": $demo2 = "40+"; break;
  }
  switch ($qn3) {
    case "A": $demo3 = "0-1 day"; break;
    case "B": $demo3 = "2-3 days"; break;
    case "C": $demo3 = "4-5 days"; break;
    case "D": $demo3 = "6-7 days"; break;
  }
  switch ($qn4) {
    case "A": $demo4 = "Newbie"; break;
    case "B": $demo4 = "Casual"; break;
    case "C": $demo4 = "Softcore"; break;
    case "D": $demo4 = "Hardcore"; break;
  }
  switch ($qn5) {
    case "A": $demo5 = "Hard copies"; break;
    case "B": $demo5 = "Phones/Tablets"; break;
    case "C": $demo5 = "Desktops/Laptops"; break;
    case "D": $demo5 = "Don't read"; break;
  }
  $ans = $qn6.$qn7.$qn8.$qn9.$qn10.$qn11.$qn12.$qn13.$qn14.$qn15.$qn16.$qn17.$qn18.$qn19.$qn20.$qn21.$qn22.$qn23.$qn24.$qn25.$qn26.$qn27.$qn28.$qn29.$qn30.$qn31.$qn32.$qn33.$qn34.$qn35.$qn36;
  $que = "INSERT INTO demographics(gender,age,frequency,reader,method,answers) VALUES('$demo1','$demo2','$demo3','$demo4','$demo5','$ans')";
  $res = mysqli_query($_SESSION['conn'], $que);
  switch ($qn6) {
    case "A": minus(4,$romance); minus(2,$schoolLife); add(2,$scifi,$psychological); add(4,$horror,$sports); break;
    case "B": minus(2,$romance); minus(1,$schoolLife); add(1,$scifi,$psychological); add(2,$horror,$sports); break;
    case "C": break;
    case "D": add(2,$romance); add(1,$schoolLife); minus(1,$scifi,$psychological); minus(2,$horror,$sports); break;
    case "E": add(4,$romance); add(2,$schoolLife); minus(2,$scifi,$psychological); minus(4,$horror,$sports); break;
  }
  switch ($qn7) {
    case "A": minus(4,$psychological,$drama); minus(2,$tragedy); add(2,$romance); add(4,$sliceOfLife,$comedy); break;
    case "B": minus(2,$psychological,$drama); minus(1,$tragedy); add(1,$romance); add(2,$sliceOfLife,$comedy); break;
    case "C": break;
    case "D": add(2,$psychological,$drama); add(1,$tragedy); minus(1,$romance); minus(2,$sliceOfLife,$comedy); break;
    case "E": add(4,$psychological,$drama); add(2,$tragedy); minus(2,$romance); minus(4,$sliceOfLife,$comedy); break;
  }
  switch ($qn8) {
    case "A": minus(4,$mystery,$historical); minus(2,$action,$adventure); add(2,$comedy,$schoolLife); add(4,$sliceOfLife); break;
    case "B": minus(2,$mystery,$historical); minus(1,$action,$adventure); add(1,$comedy,$schoolLife); add(2,$sliceOfLife); break;
    case "C": break;
    case "D": add(2,$mystery,$historical); add(1,$action,$adventure); minus(1,$comedy,$schoolLife); minus(2,$sliceOfLife); break;
    case "E": add(4,$mystery,$historical); add(2,$action,$adventure); minus(2,$comedy,$schoolLife); minus(4,$sliceOfLife); break;
  }
  switch ($qn9) {
    case "A": minus(4,$mystery,$action); minus(2,$psychological,$drama); add(2,$comedy,$sliceOfLife); add(4,$ecchi,$sports); break;
    case "B": minus(2,$mystery,$action); minus(1,$psychological,$drama); add(1,$comedy,$sliceOfLife); add(2,$ecchi,$sports); break;
    case "C": break;
    case "D": add(2,$mystery,$action); add(1,$psychological,$drama); minus(1,$comedy,$sliceOfLife); minus(2,$ecchi,$sports); break;
    case "E": add(4,$mystery,$action); add(2,$psychological,$drama); minus(2,$comedy,$sliceOfLife); minus(4,$ecchi,$sports); $pastPlaysABigRole->includ(); break;
  }
  switch ($qn10) {
    case "A": minus(4,$sliceOfLife,$schoolLife,$historical); minus(2,$romance,$sports); add(2,$adventure); add(4,$fantasy,$supernatural,$scifi); break;
    case "B": minus(2,$sliceOfLife,$schoolLife,$historical); minus(1,$romance,$sports); add(1,$adventure); add(2,$fantasy,$supernatural,$scifi); break;
    case "C": break;
    case "D": add(2,$sliceOfLife,$schoolLife,$historical); add(1,$romance,$sports); minus(1,$adventure); minus(1,$fantasy,$supernatural,$scifi); break;
    case "E": add(4,$sliceOfLife,$schoolLife,$historical); add(2,$romance,$sports); minus(2,$adventure); minus(4,$fantasy,$supernatural,$scifi); break;
  }
  switch ($qn11) {
    case "A": minus(4,$ecchi); minus(2,$comedy); break;
    case "B": minus(2,$ecchi); minus(1,$comedy); break;
    case "C": break;
    case "D": add(2,$ecchi); add(1,$comedy); break;
    case "E": add(4,$ecchi); add(2,$comedy); break;
  }
  switch ($qn12) {
    case "A": minus(4,$comedy); minus(2,$sliceOfLife); add(2,$mystery,$psychological); add(4,$horror,$tragedy); break;
    case "B": minus(2,$comedy); minus(1,$sliceOfLife); add(1,$mystery,$psychological); add(2,$horror,$tragedy); break;
    case "C": break;
    case "D": add(2,$comedy); add(1,$sliceOfLife); minus(1,$mystery,$psychological); minus(2,$horror,$tragedy); break;
    case "E": add(4,$comedy); add(2,$sliceOfLife); minus(2,$mystery,$psychological); minus(4,$horror,$tragedy); break;
  }
  switch ($qn13) {
    case "A": minus(4,$action); minus(2,$supernatural,$adventure); $specialAbility->exclud(); break;
    case "B": minus(2,$action); minus(1,$supernatural,$adventure); break;
    case "C": break;
    case "D": add(2,$action); add(1,$supernatural,$adventure); break;
    case "E": add(4,$action); add(2,$supernatural,$adventure); $specialAbility->includ(); break;
  }
  switch ($qn14) {
    case "A": minus(4,$horror,$drama,$mystery); minus(2,$psychological,$tragedy); break;
    case "B": minus(2,$horror,$drama,$mystery); minus(1,$psychological,$tragedy); break;
    case "C": break;
    case "D": add(2,$horror,$drama,$mystery); add(1,$psychological,$tragedy); break;
    case "E": add(4,$horror,$drama,$mystery); add(2,$psychological,$tragedy); break;
  }
  switch ($qn15) {
    case "A": minus(4,$sports); minus(2,$schoolLife); break;
    case "B": minus(2,$sports); minus(1,$schoolLife); break;
    case "C": break;
    case "D": add(2,$sports); add(1,$schoolLife); break;
    case "E": add(4,$sports); add(2,$schoolLife); break;
  }
  switch ($qn16) {
    case "A": minus(4,$supernatural,$fantasy); minus(2,$adventure); break;
    case "B": minus(2,$supernatural,$fantasy); minus(1,$adventure); break;
    case "C": break;
    case "D": add(2,$supernatural,$fantasy); add(1,$adventure); break;
    case "E": add(4,$supernatural,$fantasy); add(2,$adventure); break;
  }
  switch ($qn17) {
    case "A": minus(4,$comedy,$sliceOfLife); break;
    case "B": minus(2,$comedy,$sliceOfLife); break;
    case "C": break;
    case "D": add(2,$comedy,$sliceOfLife); break;
    case "E": add(4,$comedy,$sliceOfLife); break;
  }
  switch ($qn18) {
    case "A": minus(4,$ecchi); minus(2,$comedy,$schoolLife); break;
    case "B": minus(2,$ecchi); minus(1,$comedy,$schoolLife); break;
    case "C": break;
    case "D": add(2,$ecchi); add(1,$comedy,$schoolLife); break;
    case "E": add(4,$ecchi); add(2,$comedy,$schoolLife); break;
  }
  switch ($qn19) {
    case "A": minus(4,$romance); minus(2,$schoolLife,$ecchi); break;
    case "B": minus(2,$romance); minus(1,$schoolLife,$ecchi); break;
    case "C": break;
    case "D": add(2,$romance); add(1,$schoolLife,$ecchi); break;
    case "E": add(4,$romance); add(2,$schoolLife,$ecchi); break;
  }
  switch ($qn20) {
    case "A": minus(4,$scifi); add(4,$historical); break;
    case "B": minus(2,$scifi); add(2,$historical); break;
    case "C": break;
    case "D": add(2,$scifi); minus(2,$historical); break;
    case "E": add(4,$scifi); minus(4,$historical); break;
  }
  switch ($qn21) {
    case "A": minus(4,$psychological); minus(2,$drama); break;
    case "B": minus(2,$psychological); minus(1,$drama); break;
    case "C": break;
    case "D": add(2,$psychological); add(1,$drama); break;
    case "E": add(4,$psychological); add(2,$drama); break;
  }
  switch ($qn22) {
    case "A": $leadCharacter->name = "Female ". $leadCharacter->name; break;
    case "B": $leadCharacter->name = "Male ". $leadCharacter->name; break;
    case "C": break;
    case "D": break;
    case "E": $leadCharacter->name = "Male ". $leadCharacter->name; break;  //Default the lead character to be male
  }
  switch ($qn23) {
    case "A": $leadCharacter->name = "Smart ". $leadCharacter->name; break;
    case "B": $leadCharacter->name = "Strong ". $leadCharacter->name; break;
    case "C": $leadCharacter->name = "Popular ". $leadCharacter->name; break;
    case "D": if ($leadCharacter->name[0] == "F") $leadCharacter->name = "Beautiful ". $leadCharacter->name; 
                                      else  $leadCharacter->name = "Handsome ". $leadCharacter->name; break;
    case "E": $leadCharacter->name = "Young ". $leadCharacter->name; break;
    case "F": $leadCharacter->exclud(); break;
  }
  switch ($qn24) {
    case "A": add(3,$drama); $loveTriangle->includ(); break;
    case "B": minus(3,$drama); $loveTriangle->exclud(); break;
    case "C": break;
    case "D": minus(3,$romance); break;
  }
  switch ($qn25) {
    case "A": $childhoodFriend->includ(); break;
    case "B": $friendsBecomeLovers->includ(); break;
    case "C": $firstLove->includ(); break;
    case "D": $unexpressedFeelings->includ(); $unrequitedLove->includ(); break;
    case "E": $infidelity->includ(); break;
    case "F": minus(3,$romance); break;
  }
  switch ($qn26) {
    case "A": $violence->includ(); break; 
    case "B": break;
    case "C": $violence->exclud(); break;
  }
  switch ($qn27) {
    case "A": $bloodAndGore->includ(); break; 
    case "B": break;
    case "C": $bloodAndGore->exclud(); break;
  }
  switch ($qn28) {
    case "A": $century->includ(); break;
    case "B": add(3,$historical); break;
    case "C": add(3,$scifi); break;
    case "D": break;
  }
  switch ($qn29) {
    case "A": $magic->includ(); break;
    case "B": $magic->exclud(); break;
    case "C": break;
  }
  switch ($qn30) {
    case "A": $monster->includ(); break;
    case "B": $monster->exclud(); break;
    case "C": break;
  }
  switch ($qn31) {
    case "A": $specialAbility->exclud(); break;
    case "B": $specialAbility->includ(); break;
    case "C": break;
  }
  switch ($qn32) {
    case "A": add(3,$romance); $confession->includ(); break;
    case "B": add(3,$action); break;
    case "C": add(3,$action); $characterGrowth->includ(); break;
    case "D": add(3,$comedy); break;
    case "E": add(2,$action); add(3,$drama); $revenge->includ(); break;
  }
  switch ($qn33) {
    case "A": add(3,$action,$adventure); break;
    case "B": add(3,$romance,$drama); break;
    case "C": add(4,$ecchi); break;
    case "D": add(3,$mystery,$psychological,$horror); break;
    case "E": add(3,$action,$supernatural); break;
  }
  switch ($qn34) {
    case "A": add(3,$drama,$romance,$tragedy); break;
    case "B": add(3,$action,$supernatural); break;
    case "C": add(3,$comedy,$schoolLife,$sliceOfLife); break;
    case "D": break;
  }
  switch ($qn35) {
    case "A": add(3,$drama,$mystery); break;
    case "B": add(3,$adventure,$action,$fantasy,$supernatural); break;
    case "C": add(3,$romance,$sliceOfLife); break;
    case "D": add(3,$mystery,$fantasy); break;
    case "E": add(3,$comedy,$sliceOfLife); break;
  }
  switch ($qn36) {
    case "A": add(3,$schoolLife,$adventure); $friendship->includ(); break;
    case "B": add(3,$romance,$drama); break;
    case "C": add(3,$sports,$adventure); break;
    case "D": add(3,$historical,$action); break;
    case "E": add(3,$historical,$sports,$action,$drama); break;
  }

  function genrecmp($a,$b) {
    if ($a->score > $b->score)  return -1;
    else if ($a->score < $b->score) return 1;
    else        return 0;
  }
  $allGenres = array($action,$adventure,$comedy,$drama,$ecchi,$fantasy,$historical,$horror,$mystery,$psychological,$romance,$schoolLife,$scifi,$sliceOfLife,$sports,$supernatural,$tragedy);
  usort($allGenres,"genrecmp");
  $topGenres = $allGenres[0]->name . "_" . $allGenres[1]->name . "_" . $allGenres[2]->name;
  $excludedGenres = "Hentai_Smut_Yuri_Yaoi";

  $allCate = array($leadCharacter,$century,$bloodAndGore,$characterGrowth,$childhoodFriend,$confession,$firstLove,$friendsBecomeLovers,$friendship,$infidelity,$loveTriangle,$magic,$monster,$pastPlaysABigRole,$revenge,$specialAbility,$unexpressedFeelings,$unrequitedLove,$violence);
  $includedCate = array("_");
  $results = array();

  //Get recommendation section
  $names = array();
  $url = 'https://www.mangaupdates.com/series.html?perpage=50&genre=' . rawurlencode($topGenres) . '&exclude_genre=' . $excludedGenres . '&orderby=rating&category=';
  foreach($allCate as $cate) {
    if ($cate->exclu)
      $url = $url . '-' . rawurlencode($cate->name) . "_";
    else if ($cate->inclu)
      $includedCate[] = $cate->name;
  }
  foreach($includedCate as $cate) {
    $newURL = $url . rawurlencode($cate) . "_";
    $data = get_remote_data($newURL);
    $html = str_get_html($data);
    // Find all <td> in <table> which class=text pad col4 
    $table = $html->find('.series_rows_table')[0];
    $names = array();
    if ($table == null)
      continue;
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
            if(stripos($plainName, "(Novel)") !== false) {
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
    $results[] = $names;
  }
  $names = array();
  $cateNum = count($results);
  for ($x = 0; $x < 50; $x++) {
    for ($i = 0; $i < $cateNum; $i++) {
      $list = $results[$i];
      if (isset($list[$x])) {
        $name = $list[$x];
        if (!in_array($name, $names)) {
          $names[] = $name;
        }
      }
    }
  }
  $count = 0;
  $ID_list = array();
  foreach($names as $name) {
    $id = manga_entry($name);
    if ($id != 0) {
      $ID_list[] = $id;
      var_dump($id);
      $count++;
    }
    if ($count == 20)
      break;
  }
  //$ID_list = array_map('manga_entry', $names);
  header("Location: recommendations.php?save_recommendations=1&idlist=" . implode("_", $ID_list));