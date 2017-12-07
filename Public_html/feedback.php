<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  ini_set('max_execution_time', 5);

  $user     = $_POST["userName"];
  $NUS      = $_POST["NUS"];
  $feedback = mysqli_real_escape_string($_SESSION['conn'], $_POST["feedback"]);

  $que = "INSERT INTO feedback(userName,NUS,subject) VALUES('$user','$NUS','$feedback')";
  $res = mysqli_query($_SESSION['conn'], $que);
  if ($res == false) {
    echo "Something was wrong. Please submit your feedback later.";
  } else {
    echo "Your feedback has been submitted. We thank you for your contribution.";
  }
  ob_end_flush();
?>