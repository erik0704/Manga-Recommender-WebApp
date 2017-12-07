<?php
	ob_start();
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
	require_once 'dbconnect.php';
	// if session is not set this will redirect to login page
	if( !isset($_SESSION['user']) ) {
		header("Location: index.php");
		exit;
	}
	// select loggedin users detail
  $user = $_SESSION['user'];
	$res=mysqli_query($_SESSION['conn'], "SELECT * FROM users WHERE userName='$user'");
	$userRow = mysqli_fetch_array($res);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Welcome - <?php echo $userRow['userName']; ?></title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
  <link rel="stylesheet" href="stylesheet.css">
</head>

<style>
.welcome {
  font-family: "Wildwords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;
  height: 90px;
  line-height: 90px;
  width: 66%;
  margin: 20px 17%;
  text-align: center;
  border: 2px dashed #f69c55;
}
#allRead {
  margin: 50px 17% 0 17%;
  width: 66%;
}
table, th, td {
    border: 1px solid #ddd;
    border-collapse: collapse;
    table-layout: fixed;
}
td {
  height: 90px;
  width: 50%;
  vertical-align: top;
}
.row::after {
  content: "";
  clear: both;
  display: table;
}
.column {
  float: left;
  width: 33.3%;
  margin-bottom: 10px;
  padding: 0 8px;
}
.card img {
  height: 100px;
  display: inline-block; 
  margin: auto;
}
.rightColumn {
  width: 450px;
  float: right;
  background: #aafed6;
}
.leftColumn {
    float: none; /* not needed, just for clarification */
    /* the next props are meant to keep this block independent from the other floated one */
    width: auto;
    overflow: hidden;
    background: #e8f6fe;
}​​
@media (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  overflow: hidden;
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
.mangaIMG {
  width: 65px;
  float: left;
}
.mangaName {
  line-height: 90px;
  text-align: left;
  float: none; /* not needed, just for clarification */
  /* the next props are meant to keep this block independent from the other floated one */
  width: auto;
  overflow: hidden;
  padding-left: 1em;
}​​
</style>

<body class="w3-display-container w3-sand">
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s2">
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s2">
      <a href="#" class="w3-button w3-block w3-black">VIEW PROFILE</a>
    </div>
    <div class="w3-col s4" align="middle"><img src="Images/alt_logo.png" alt="logo" style="height:38px;"></div>
    <div class="w3-col s2">
      <a href=<?php echo 'recommendations.php?idlist=' . $userRow['recList']; ?> class="w3-button w3-block w3-black">VIEW RECOMMENDATIONS</a>
    </div>
    <div class="w3-col s2">
      <a href="#" class="w3-button w3-block w3-black dropbtn" onclick="dropMenu()"><?php echo $userRow['userName']; ?></a>
      <div class="dropdown-content" id="accountMenu">
        <a href="home.php">Dashboard</a>
        <a href="#">Account Settings</a>
        <a href="logout.php?logout">Sign Out</a>
        <span 
    </div>
    </div>
  </div>
</div>

<div class="w3-sand w3-large">
  <h1 class="welcome">WELCOME, <?php echo $userRow['userName']; ?></h1>
  <div class="w3-center" id="allRead">
    <h4 style='font-family: "Wildwords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;'>Your manga list</h4>
    <?php
    $count = 0;
    if ($userRow['readManga'] == NULL) {
      echo '<div style="margin: 15px 0; text-align: center"><i>You have no manga in your list</i></div>';
    }
    else {
      $string_list = explode("_", $userRow['readManga']);
      $ID_list = array_map('intval', $string_list);
      
      //echo '<table style="width:100%">';
      foreach($ID_list as $id) {
        $query = mysqli_query($_SESSION['conn'], "SELECT id, mal_name, mu_name, img FROM mangas WHERE id='$id'"); 
        $manga = mysqli_fetch_array($query);
        if ($count % 3 == 0) {
          echo '<div class="row">';
        }
        $name = "";
        if (isset($manga['mal_name'])) { $name = $manga['mal_name']; }
        else { $name = $manga['mu_name']; }
        echo '<a href="manga.php?id=' . $manga['id'] . '"><div class="column"><div class="card" align="left"><div class="mangaIMG"><img style="height:90px;width:65px;vertical-align:middle" src="' . $manga['img'] . '"></div><div class="mangaName"><span style="display: inline-block;vertical-align: middle;line-height: normal">' . $name . '</span></div></div></div></a>';
        if ($count % 3 == 2) {
          echo '</div>';
        }
        $count++;
      }
      if ($count % 3 != 0) {
        echo '</div>';
      }
      echo '<div style="margin: 15px 0; text-align: center"><i>You have read ' . $count . ' manga(s)</i></div>';
      /*echo '<table style="width:100%">';
      foreach($ID_list as $id) {
        $que=mysqli_query($_SESSION['conn'], "SELECT name, img, mal_id FROM manga_img WHERE id='$id'");
        $manga = mysqli_fetch_array($que);
        if ($count % 2 == 0) {
          echo '<tr>';
        }
        echo '<td><a href="https://myanimelist.net/manga/' . $manga['mal_id'] . '" style="text-decoration:none"><img style="height:90px;width:65px;vertical-align:middle" src="' . $manga['img'] . '"><span style="padding-left:1em">' . $manga['name'] . '</span></a></td>';
        if ($count % 2 == 1) {
          echo '</tr>';
        }
        $count++;
      }
      echo '</td></table>';*/
    }
    ?>
    <div class="w3-button w3-indigo w3-hover-red" style="border-radius: 10px"><a href="search.php" style="text-decoration: none">Add more mangas</a></div>
  </div> 
</div>
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