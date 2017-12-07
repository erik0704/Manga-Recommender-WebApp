<?php
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  ob_start();
	require_once 'dbconnect.php';
	require_once 'simple_html_dom.php';
  require_once 'functions.php';

  $user = "undefined";
	// if session is not set this will redirect to login page
	if(isset($_SESSION['user']) ) {
		$user = $_SESSION['user'];
	}
  $res=mysqli_query($_SESSION['conn'], "SELECT * FROM users WHERE userName='$user'");
  $userRow = mysqli_fetch_array($res);
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
@font-face {
  font-family: WildWords;
  src: url(WildWords.ttf);
}
#manga {
  width: 60%;
  margin: 100px auto 50px auto;
}
.round-button {
  border-radius:10px;
  width:100%;
  margin:2px 0;
}
.section {
  width: 60%;
  margin: 50px auto;
}
header {
  text-align: center;
  background: black;
  color: white;
  padding:2px 0;
}
.subheader {
  border-bottom:1px solid lightgrey;
  font-weight: bold;
  margin:10px auto 2px auto;
}
.review {
  margin:10px auto 10px auto;
}
.subject {
  height:90px;
  background-color: lightgrey;
  padding:1px 20px 10px 20px;
  border-top: 1px solid #aaa;
  border-bottom: 1px solid #aaa;
  font-size: 15px;
}
.rating {
  background-color: #bbb;
  padding: 5px;
  float:right;
  border-top: 1px solid #aaa;
  border-bottom: 1px solid #aaa;
  margin-top:25px;
}
.content {
  padding:1px 20px;
  margin:10px 0 0 0;
  font-size: 15px;
}
.row {
  height: auto;
  overflow: hidden;
}
.rightColumn {
  width: 300px;
  float: right;
  align-content: center;
}
.leftColumn {
    float: none; /* not needed, just for clarification */
    /* the next props are meant to keep this block independent from the other floated one */
    width: auto;
    overflow: hidden;
    padding:15px;
    font-size:15px;
    text-align: justify;
    text-justify: inter-word;
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
.column {
  float: left;
  width: 25%;
  margin-bottom: 16px;
  padding: 0 8px;
}
.card img {
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
input[type=text], input[type=password], select, textarea {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
/* The snackbar - position it at the bottom and in the middle of the screen */
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
      <a href=<?php echo 'recommendations.php?idlist=' . $userRow['recList']; ?> class="w3-button w3-block w3-black">VIEW RECOMMENDATIONS</a>
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

<iframe id="hiddenFrame" name="hiddenFrame" style="display:none;"></iframe>
<div id="noticeSnackbar"></div>
<div class="w3-sand w3-large">
  <div id="manga">
    <?php
      $manga = getMangaById(70);
      if (isset($_GET['id'])) {
        $manga = getMangaById($_GET['id']);
      } else if (isset($_GET['name'])) {
        $manga = getMangaByName($_GET['name']);
      }
    ?>
    <header>
      <div align="center">
        <h2 style='font-family: "WildWords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;'><?php echo $manga['mal_name'];?></h2>
      </div>
    </header>
    <div class="row">
      <div class="rightColumn w3-center">
        <div><img src=<?php echo $manga['img'];?> style="width:225px;margin:7px auto 2px auto"></div>
        <a href=<?php echo "add_manga.php?id=" . $manga['id'] . '&user=' . $user;?> style="text-decoration: none" target="hiddenFrame" onclick="setTimeout(showNotice, 100)">
          <div class="w3-button w3-indigo w3-hover-red round-button">Add to manga list</div>
        </a>
        <div class="w3-center">
          <table>
            <tbody>
              <tr>
                <div>
                  <td width="300px" style="text-align: center">
                    <h2><b><?php echo $manga['mal_score']; ?></b></h2>
                    <h5>MyAnimeList's score</h5>
                    <a href=<?php echo "https://myanimelist.net/manga/" . $manga['mal_id'];?> style="text-decoration: none" target="_blank">
                      <div class="w3-button w3-blue w3-hover-teal round-button">MAL Page</div>
                    </a>
                  </td>
                  <td width="50%" style="text-align: center">
                    <?php 
                      if ($manga['mu_score'] == null) {
                        echo '<i>Data of this manga from MangaUpdates is not yet in our database</i>';
                      } else {
                    ?>
                    <h2><b><?php echo $manga['mu_score']; ?></b></h2>
                    <h5>MangaUpdates' score</h5>
                    <a href=<?php echo "https://www.mangaupdates.com/series.html?id=" . $manga['mu_id'];?> style="text-decoration: none" target="_blank">
                      <div class="w3-button w3-green w3-hover-lime round-button">MU page</div>
                    </a>
                    <?php } ?>
                  </td>
                </div>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="leftColumn">
        <div class="subheader">Alternative titles</div>
        <span><?php echo $manga['alt_title']; ?></span>
        <div class="subheader">Synopsis</div>
        <span><?php echo $manga['synop']; ?></span>
        <div class="subheader">Published Period</div>
        <span><?php echo 'From ' . convertDate($manga['start']) . ' to ' . convertDate($manga['finish']); ?></span>
        <div class="subheader">Status</div>
        <span><?php echo $manga['status']; ?></span>
        <div class="subheader">Volumes</div>
        <span>
        <?php 
          if ($manga['vol'] == 0)
            echo "Undetermined";
          else
            echo $manga['vol']; 
        ?>
        </span>
        <div class="subheader">Chapters</div>
        <span>
        <?php 
          if ($manga['chap'] == 0)
            echo "Undetermined";
          else
            echo $manga['chap']; 
        ?>
        </span>
      </div>
    </div>
  </div> 
  <div class="section">
    <div class="subheader"><h3>User reviews</h3></div>
    <?php
      if (isset($_GET['id'])) {
        $reviews = getReviewsFromManga($_GET['id']);
        $count = sizeof($reviews);
        if ($count == 0) {
          echo "<div class='w3-center w3-padding-32'><em>There are no user reviews for this manga</em></div>";
        } else {
          foreach ($reviews as $review) {
            $up = $review['upvote'];
            $upvoters = array();
            if ($up == null)
              $up = 0;
            else {
              $upvoters = explode("_", $up);
              $up = sizeof($upvoters);
            }
            $down = $review['downvote'];
            $downvoters = array();
            if ($down == null)
              $down = 0;
            else {
              $downvoters = explode("_", $down);
              $down = sizeof($downvoters);
            }
            $score = $up - $down;
            echo '<div class="review"><div class="subject">';
            if ($score > 0)
              echo '<div class="rating">Score: <span style="color:green">+' . $score . '</span></div>';
            else if ($score < 0)
              echo '<div class="rating">Score: <span style="color:red">' . $score . '</span></div>';
            else
              echo '<div class="rating">Score: ' . $score . '</div>';
            echo '<div style="float:left"><img src="Images/anon.png" alt="Avatar" style="height:80px; margin:3px 10px 0 0"></div>';
            echo '<div><h4><strong>' . $review['subject'] . '</strong></h4><span>by <u>' . $review['userName'] . '</u></span></div>';
            echo '</div><div class="content">' . $review['content'] . '</div>';
            echo '<div align="right">';
            if ($user != "undefined") {
              if (in_array($user, $upvoters))
                echo '<div class="w3-button w3-lime round-button" style="width:130px">Upvoted!</div>';
              else
                echo '<a href="vote_review.php?review_id=' . $review['id'] . '&vote=1" target="hiddenFrame"><div class="w3-button w3-green w3-hover-lime round-button" style="width:130px" onclick="setTimeout(showNotice, 100)">Upvote</div></a>';
              if (in_array($user, $downvoters))
                echo '<div class="w3-button w3-orange round-button" style="width:130px">Downvoted!</div>';
              else
                echo '<a href="vote_review.php?review_id=' . $review['id'] . '&vote=0" target="hiddenFrame"><div class="w3-button w3-red w3-hover-orange round-button" style="width:130px" onclick="setTimeout(showNotice, 100)">Downvote</div></a>';
            } else {
              echo '<em>Sign in to vote</em>';
            }
            echo '</div></div>';
          }
        }
      }
    ?>
  </div>
  <div class="section">
    <div class="subheader"><h3>Write your own review</h3></div>
    <?php 
    if ($user == "undefined") {
      echo "<div class='w3-center w3-padding-32'><em>Sign in to write review</em></div>";
    } else {
    ?>
    <form class="modal-content animate" action="review.php" method="post" target="hiddenFrame">
      <div class="container">
        <label for="subject"><b>Subject</b></label>
        <input type="text" id="subject" placeholder="Enter the subject of the review" name="subject" required><br/>
        <label for="content"><b>Review</b></label>
        <textarea id="content" name="content" placeholder="Write something.." style="height:200px" required></textarea>
        <?php echo '<input type="text" id="manga_id" name="manga_id" value="' . $_GET['id'] . '" style="display:none">'; ?>
        <button type="submit" onclick="setTimeout(showNotice, 100); var frame = document.getElementById('hiddenFrame'); var frameDocument = frame.contentDocument || frame.contentWindow.document; frameDocument.body.innerHTML = 'Your review has been added!'">Submit</button>
      </div>
    </form>
    <?php } ?>
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