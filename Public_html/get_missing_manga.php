<?php 
require_once 'simple_html_dom.php';
require_once 'functions.php';
require_once 'dbconnect.php';
ini_set('max_execution_time', 1200);
ob_start();
if(!isset($_SESSION)) { 
  session_start(); 
} 
$count = 1;
for ($page = 11; $page <= 20; $page++) {
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
            if(stripos($plainName, "(Novel)") !== false) {
                continue;
            }
            //Check if the current manga is in the database
            $query = "SELECT * FROM mangas WHERE mu_name='$plainName'";
            $result = mysqli_query($_SESSION['conn'], $query);
            $number = mysqli_num_rows($result);
            
            //If it doesn't
            if ($number == 0) {
            	echo $count . ". Title: <i>" . $plainName . "</i>; mu_id: <b>" . $mu_id . "</b>; mu_score: <u>" . $mu_score . "</u><br />";
            	$count++;
            }
        }
    }
}
ob_end_flush();
?>