<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  ini_set('max_execution_time', 5);

  $review_id = $_GET['review_id'];
  $vote     = $_GET['vote'];
  $user     = $_SESSION['user'];

  $review = getReviewById($review_id);
  $que = "";
  if ($vote == 1) {     //upvote
    $up = $review['upvote'];
    if ($up == null || $up == "") {
      $up = $user;
    } else {
      $up = $up . "_" . $user;
    }
    $down = $review['downvote'];
    $downvoters = explode("_", $down);
    $newDownVoters = implode("_",array_diff($downvoters,array($user)));
    $que = "UPDATE review SET upvote='$up',downvote='$newDownVoters' WHERE id='$review_id'";
  } else {
    $down = $review['downvote'];
    if ($down == null || $down == "") {
      $down = $user;
    } else {
      $down = $down . "_" . $user;
    }
    $up = $review['upvote'];
    $upvoters = explode("_", $up);
    $newUpVoters = implode("_",array_diff($upvoters,array($user)));
    $que = "UPDATE review SET upvote='$newUpVoters',downvote='$down' WHERE id='$review_id'";
  }

  $res = mysqli_query($_SESSION['conn'], $que);
  if ($res == false) {
    echo "Something was wrong. Please submit your feedback later.";
  } else {
    echo "Your vote has been cast!";
  }
  ob_end_flush();
?>