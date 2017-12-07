<?php
	ob_start();
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
	require_once 'dbconnect.php';
	require_once 'simple_html_dom.php';
  require_once 'functions.php';
  ini_set('max_execution_time', 60); //60 seconds = 1 minute

  $user = "undefined";
	// if session is not set this will redirect to login page
	if(isset($_SESSION['user']) ) {
		$user = $_SESSION['user'];
	}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Your Manga Recommendations</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
  <link rel="stylesheet" href="stylesheet.css">
</head>

<style>
#allRec {
  width: 60%;
  margin: 75px auto 0 auto;
}
.dropdown {
    float: right;
    overflow: hidden;
    cursor: pointer;
    font-size: 16px;    
    border: none;
    outline: none;
    color: white;
    padding: 14px 16px;
    background-color: inherit;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 315px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
}

.dropdown-content a {
    float: none;
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
    text-align: left;
}

.dropdown-content a:hover {
    background-color: #ddd;
}

.show {
    display: block;
}
.column {
  float: left;
  width: 285px;
  margin-bottom: 16px;
  padding: 0 8px;
}
.card img {
  width:100%;
  height: 375px;
  display: block; 
  margin: auto;
}
@media (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

.container {
  padding: 0 16px;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}
#noticeSnackbar {
    visibility: hidden; /* Hidden by default. Visible on click */
    min-width: 250px; /* Set a default minimum width */
    margin-left: -125px; /* Divide value of min-width by 2 */
    background-color: #333; /* Black background color */
    color: #fff; /* White text color */
    text-align: center; /* Centered text */
    border-radius: 2px; /* Rounded borders */
    padding: 16px; /* Padding */
    position: fixed; /* Sit on top of the screen */
    z-index: 1; /* Add a z-index if needed */
    left: 49%; /* Center the snackbar */
    bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#noticeSnackbar.show {
    visibility: visible; /* Show the snackbar */

/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
However, delay the fade out process for 2.5 seconds */
    -webkit-animation: fadein 0.5s, fadeout 0.5s 4.5s;
    animation: fadein 0.5s, fadeout 0.5s 4.5s;
}

/* Animations to fade the snackbar in and out */
@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}
</style>

<body class="w3-display-container w3-sand">
<!-- Links (sit on top)-->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s2">
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s2">
      <a href="home.php" class="w3-button w3-block w3-black">VIEW PROFILE</a>
    </div>
    <div class="w3-col s4" align="middle"><img src="Images/alt_logo.png" alt="logo" style="height:38px;"></div>
    <div class="w3-col s2">
      <a href="#" class="w3-button w3-block w3-black">VIEW RECOMMENDATIONS</a>
    </div>
    <div class="w3-col s2" id="userSignedIn">
      <a href="#" class="w3-button w3-block w3-black dropbtn" onclick="dropMenu()"><?php echo $user; ?></a>
      <div class="dropdown-content" id="accountMenu">
        <a href="home.php">Dashboard</a>
        <a href="#">Account Settings</a>
        <a href="logout.php?logout">Sign Out</a>
      </div>
    </div>
    <div class="w3-col s2" id="userNotSignedIn">
      <a href="register.php" class="w3-button w3-block w3-black">SIGN UP</a>
    </div>
    <?php
      if (isset($_SESSION['user'])) {
        echo "<script> document.getElementById('userSignedIn').style.display='block'; document.getElementById('userNotSignedIn').style.display='none'; </script>";
      } else {
        echo "<script> document.getElementById('userNotSignedIn').style.display='block'; document.getElementById('userSignedIn').style.display='none'; </script>";
      }
    ?>
  </div>
</div> 

<div class="w3-sand w3-large">
  <div  id="allRec">
    <h4 style='font-family: "Wildwords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;'>Mangas you may like</h4>
    <?php
      $count = 0;
      $ID_list = 0;
      $readManga = 0;
      if (isset($_GET['top'])) {
        $name_list = get_top_recommendation($_GET['top']);
        $ID_list = array_map('manga_entry', $name_list);
      } else if (isset($_GET['idlist'])) {
        $string_list = explode("_", $_GET['idlist']);
        $ID_list = array_map('intval', $string_list);
      } else if ($user != "undefined") {
        $que=mysqli_query($_SESSION['conn'], "SELECT recList FROM users WHERE userName='$user'");
        $userRow = mysqli_fetch_array($que);
        $string_list = explode("_", $userRow['recList']);
        $ID_list = array_map('intval', $string_list);
      } else {
        header("Location: index.php");
        exit;
      }
      if ($user!="undefined" && isset($_GET['save_recommendations'])) {
          save_recommendations($user, implode("_", $ID_list));
        } else {
          $_SESSION['last_rec'] = implode("_", $ID_list);
        }
      if (isset($_SESSION['user'])) {
        $que=mysqli_query($_SESSION['conn'], "SELECT * FROM users WHERE userName='$user'");
        $userRow = mysqli_fetch_array($que);
        $string_list = explode("_", $userRow['readManga']);
        $readManga = array_map('intval', $string_list);
      }
      foreach($ID_list as $id) {
        if ($count < 8) {
          if ($count % 4 == 0) {
            echo '<div class="row">';
          }
          if ($id == 0) {
            continue;
          } else if ($readManga != 0) {
            if (in_array($id, $readManga)) {
              continue;
            }
          }
          $sql = mysqli_query($_SESSION['conn'], "SELECT id, mal_name, mu_name, img FROM mangas WHERE id='$id'"); 
          $manga = mysqli_fetch_array($sql);
          /*$infostart = stripos($n, 'Info');
          $endstart = stripos($n, '</a>');
          $plainName = substr($n, $infostart + 6, $endstart - $infostart - 6);
          if(stripos($plainName, "(Novel)") !== false) {
            continue;
          }
          $mal = myanimelist_api($plainName);
          
          $id = $mal['id'];
          $imgURL = $mal['image'];
          if ($imgURL == null) {
            continue;
          }*/
          $name = "";
          if (isset($manga['mal_name'])) { $name = $manga['mal_name']; }
          else { $name = $manga['mu_name']; }
          echo '<a href="manga.php?id=' . $manga['id'] . '"><div class="column"><div class="card" align="middle"><img class="w3-center" src="' . $manga['img'] . '"><h5>' . $name . '</h5></div></div></a>';

          if ($count % 4 == 3) {
            echo '</div>';
          }
          $count++;
        }
      }
    ?>
  </div> 
</div>
<div id="noticeSnackbar"><h5>Sign up to save the recommendations</h5></div>
<?php
  if ($user == "undefined") {
    echo "<script>var notice = document.getElementById('noticeSnackbar');notice.className = 'show';setTimeout(function(){ notice.className = notice.className.replace('show', ''); }, 5000);</script>";
  }
?>
</body>
</html>
<?php ob_end_flush(); ?>

<script>
function dropMenu() {
    document.getElementById("accountMenu").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
    var myDropdown = document.getElementById("accountMenu");
      if (myDropdown.classList.contains('show')) {
        myDropdown.classList.remove('show');
      }
  }
}
</script>