<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  ini_set('max_execution_time', 5);

  $manga_id = $_POST['manga_id'];
  $subject  = mysqli_real_escape_string($_SESSION['conn'], $_POST["subject"]);
  $content  = mysqli_real_escape_string($_SESSION['conn'], $_POST["content"]);
  $user     = $_SESSION['user'];

  $que = "INSERT INTO review(manga_id,userName,subject,content) VALUES('$manga_id','$user','$subject','$content')";
  $res = mysqli_query($_SESSION['conn'], $que);
  if ($res == false) {
    echo "Something was wrong. Please submit your feedback later.";
  } else {
    echo "Your review has been added!";
  }
  ob_end_flush();
?>