<?php
  ob_start();
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  $manga = getMangaById(70);
  $mal_manga = myanimelist_api($manga['mal_name'],$manga['mal_id']);
?>