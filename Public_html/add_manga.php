<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  require_once 'functions.php';

  $user = "LeonidAgarth";
  // if session is not set this will redirect to login page
  if(isset($_SESSION['user']) ) {
    $user = $_SESSION['user'];
  } else if (isset($_GET['user'])) {
    $user = $_GET['user'];
  }
  if (isset($_GET['id'])) {
    $mangaID = $_GET['id'];
    echo addManga($user, $mangaID);
  }
  ob_end_flush();
?>