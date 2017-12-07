<?php
	if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
	require_once 'dbconnect.php';
	require_once 'simple_html_dom.php';
  require_once 'functions.php';
  error_reporting(0);
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
#search {
  margin: 5% 20% 0 20%;
  width: 60%;
}
input[type=text] {
    width: 100%;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-size: 25px 25px;
    background-image: url('Images/searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    margin: 5px 0;
}
.row {
  border-top:1px solid lightgrey;
  border-bottom:1px solid lightgrey;
  height: 90px;
  overflow: hidden;
}
.rightColumn {
  width: 450px;
  float: right;
  /*background: #aafed6;*/
}
.leftColumn {
    float: none; /* not needed, just for clarification */
    /* the next props are meant to keep this block independent from the other floated one */
    width: auto;
    overflow: hidden;
    /*background: #e8f6fe;*/
}​​
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
.score {
  font-size: 25px;
  font-weight: bold;
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
    left: 50%; /* Center the snackbar */
    bottom: 30px; /* 30px from the bottom */
}

/* Show the snackbar when clicking on a button (class added with JavaScript) */
#noticeSnackbar.show {
    visibility: visible; /* Show the snackbar */

/* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
However, delay the fade out process for 2.5 seconds */
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
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

<body class="w3-display-container w3-sand" >
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
    <?php
    if ($user == "undefined") {
    ?>
    <div class="w3-col s2">
      <a href="login.php" class="w3-button w3-block w3-black">SIGN IN</a>
    </div>
    <div class="w3-col s2">
      <a href="quiz.php" class="w3-button w3-block w3-orange w3-hover-red"><span style="text-decoration: none">TAKE THE QUIZ</span></a>
    </div>
    <?php 
    } else {
    ?>
      <div class="w3-col s2">
        <a href="recommendations.php" class="w3-button w3-block w3-black">VIEW RECOMMENDATIONS</a>
      </div>
    
    <div class="w3-col s2" id="userSignedIn">
      <a href="#" class="w3-button w3-block w3-black dropbtn" onclick="dropMenu()"><?php echo $user; ?></a>
      <div class="dropdown-content" id="accountMenu">
        <a href="home.php">Dashboard</a>
        <a href="#">Account Settings</a>
        <a href="logout.php?logout">Sign Out</a>
      </div>
    </div>
    <?php
    } 
    ?>
  </div>
</div>

<iframe id="hiddenFrame" name="hiddenFrame" style="display:none;"></iframe>
<div id="noticeSnackbar"></div>
<div class="w3-sand w3-large">
  <div id="search">
    <h2 align="center">Manga Search</h2>
    <form>
      <input type="text" name="search" placeholder="Type here to search">   
    </form>
    <?php 
      if (isset($_GET['search'])) {
        $trimmed = trim(rawurldecode($_GET['search']));
        echo '<h3 align="center">Search results for: ' . $trimmed . '</h3>';
        $results = myanimelist_api_get_all($trimmed);
        foreach ($results as $manga) {
          if ($manga['type'] != 'Manga') {    //Only show manga, not One-shot or Novel or any other thing
            continue;
          } else if ($manga['score'] < 6) {  //Don't show manga whose score is too low, since it could be hentai
            continue;
          }
          $mangadb = getMangaByName($manga['title']);
          $id = "";
          if ($mangadb['id'] == null) {
            $mal_id = $manga['id'];
            $name = $manga['title'];
            $score = $manga['score'];
            if (!empty($manga['english'])) { $alt_title = $manga['english'] . "; "; }
            if (!empty($manga['synonyms'])) { $alt_title = $alt_title . $manga['synonyms']; }
            $alt_title = mysqli_real_escape_string($_SESSION['conn'], $alt_title);
            $img = $manga['image'];
            $synop = mysqli_real_escape_string($_SESSION['conn'], $manga['synopsis']);
            $vol = $manga['volumes'];
            $chap = $manga['chapters'];
            $status = $manga['status'];
            $start = $manga['start_date'];
            $finish = $manga['end_date'];
            $query = "INSERT INTO mangas(mal_id,mal_name,alt_title,mal_score,img,synop,vol, chap, status, start, finish) VALUES('$mal_id','$name','$alt_title','$score','$img','$synop','$vol','$chap','$status','$start','$finish')";
            $res = mysqli_query($_SESSION['conn'], $query);
            /*$query = "SELECT id FROM manga_img WHERE mal_id='$mal_id')";
            $res = mysqli_query($_SESSION['conn'], $query);
            $array = mysqli_fetch_array($)*/
            $id = mysqli_insert_id($_SESSION['conn']);
          } else {
            $id = $mangadb['id'];
          }
          $name = $manga['title'];
          //Blacklist feature
          $query = "SELECT * FROM blacklist WHERE mal_name='$name' OR id='$id'";
          $res = mysqli_query($_SESSION['conn'], $query);
          $count = mysqli_num_rows($res);
          if ($count > 0) {
            continue;
          }
          echo '<a href="manga.php?id=' . $id . '" style="text-decoration: none"><div class="row"><table style="width:100%"><tbody><tr>';
          echo '<td style="width:65px"><img style="height:90px;width:65px;vertical-align:middle" src="' . $manga['image'] . '"></td>';
          echo '<td style="width:auto; padding-left: 1em"><u>' . $manga['title'] .'</u></td>';
          echo '<td style="width:120px"><a href="add_manga.php?id=' . $id . '" style="text-decoration: none" target="hiddenFrame" onclick="setTimeout(showNotice, 100)"><div class="w3-button w3-indigo w3-hover-red" style="float:left;border-radius:10px;width:120px;margin:2px 0">Add to<br />manga list</div></a></td>';
          echo '<td style="width:100px;text-align: center"><div class="score">' . $manga['score'] . '</div><div>MAL score</div></td>';
          echo '<td style="width:80px"><a href="https://myanimelist.net/manga/' . $manga['id'] . '" style="text-decoration: none"><div class="w3-button w3-blue w3-hover-teal" style="float:left;border-radius:10px;width:80px;margin:2px 0">MAL<br />Page</div></a></td>';
          if ($mangadb['mu_score'] == null || $mangadb['mu_id'] == null) {
            echo '<td style="width:184px;text-align: center"><em>Not yet in our database</em>';
          } else {
            echo '<td style="width:100px;text-align: center"><div class="score">' . $mangadb['mu_score'] . '</div><div>MU score</div></td>';
            echo '<td style="width:80px"><a href="https://www.mangaupdates.com/series.html?id=' . $mangadb['mu_id'] . '" style="text-decoration: none"><div class="w3-button w3-green w3-hover-lime" style="float:left;border-radius:10px;width:80px;margin:2px 0">MU<br />Page</div></a></td>';
          }
          echo '</tr></tbody></table></div></a>';
        }
      }
    ?>
  </div> 
</div>
<footer class="w3-center w3-light-grey w3-large" style="width:100%; padding:5px">
  <p>Powered by <a href="https://myanimelist.net/modules.php?go=api" title="MyAnimeList API" target="_blank" class="w3-hover-text-green">MyAnimeList API</a></p>
</footer>
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
function showNotice() {
    // Get the snackbar DIV
    var frame = document.getElementById("hiddenFrame");
    var frameDocument = frame.contentDocument || frame.contentWindow.document;
    var text = frameDocument.body.innerHTML;
    if (text === "") {
      text = "You have added this manga to your manga list";
    }
    var notice = document.getElementById("noticeSnackbar");
    notice.innerHTML = text;
    // Add the "show" class to DIV
    notice.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ notice.className = notice.className.replace("show", ""); }, 3000);
}
</script>