<?php
  ob_start();
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
  error_reporting(0);
  require_once 'dbconnect.php';
  require_once 'simple_html_dom.php';
  require_once 'functions.php';
  
  $user = "undefined";
  // if session is not set this will redirect to login page
  if(isset($_SESSION['user']) ) {
    $user = $_SESSION['user'];
  }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Manga Recommendations</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
	<link rel="stylesheet" href="stylesheet.css">
</head>

<style>
.w3-sand {
	width: 60%;
	margin: 0 20%;
}
.motto {
    font-family: "Wildwords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;
    font-size: 40px;
    color: #D93427;
    -webkit-text-fill-color: #D93427;
    -webkit-text-stroke-width: 1px;
    -webkit-text-stroke-color: black;
}
.button {
    margin: 10px auto;
    height: 60px;
    line-height: 60px;
    width: 225px;
    background-color: #050505;
    color: white;
    font-size: 20px;
    text-align: center;
    text-transform: uppercase;
    font-weight: bold;
    letter-spacing: 1.5px;
    border: 1px solid #050505;
    border-radius: 10px;
    transition: all 0.5s;
    cursor: pointer;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}

*, *:before, *:after {
  box-sizing: inherit;
}

/* Team card */
.column {
  float: left;
  width: 50%;
  margin-bottom: 16px;
  padding: 0 8px;
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

.title {
  color: grey;
}

.contact {
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
}

.contact:hover {
  background-color: #555;
}

.menu {
    display: none;
}

/* The copy popup */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    width: 100%;
}
/* The actual popup (appears on top) */
.popuptext {
    visibility: hidden;
    width: 200px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 8px 0;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -100px;
}
/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #555 transparent transparent transparent;
}
/* Toggle this class when clicking on the popup container (hide and show the popup) */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s
}
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}
@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}

/* Login Modal*/
/* Full-width input fields */
input[type=text], input[type=password], select, textarea {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
    padding: 10px 18px;
    background-color: #f44336;
}

.cancelbtn, .signupbtn {
    float: left;
    height: 50px;
    width: 50%;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 50%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    from {transform: scale(0)} 
    to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
    span.psw {
       display: block;
       float: none;
    }
    .cancelbtn {
       width: 100%;
    }
}
/* Clear floats */
.clearfix::after {
    content: "";
    clear: both;
    display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
    .cancelbtn, .signupbtn {
        width: 100%;
    }
}
/* Snackback */
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
    left: 45%; /* Center the snackbar */
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

<body style="background: #ffffff no-repeat fixed center; background-image: linear-gradient( rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75) ), url('Images/bgimg.jpg');">
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col" style="width:20%">
      <a href="#" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col" style="width:15%">
      <a href="search.php" class="w3-button w3-block w3-black">MANGA SEARCH</a>
    </div>
    <?php
      if ($user == "undefined") {
    ?>
    <div class="w3-col" style="width:15%">
      <a href="login.php" class="w3-button w3-block w3-black">SIGN IN</a>
    </div>
    <div class="w3-col" style="width:15%">
      <a href="register.php" class="w3-button w3-block w3-black">SIGN UP</a>
    </div>
    <?php 
      } else {
    ?>
    <div class="w3-col" style="width:30%">
      <a href="home.php" class="w3-button w3-block w3-black">PROFILE</a>
    </div>
    <?php 
      }
    ?>
    <div class="w3-col" style="width:15%">
      <span onclick="document.getElementById('feedbackModal').style.display='block'" class="w3-button w3-block w3-black">FEEDBACK</span>
    </div>
    <div class="w3-col" style="width:20%">
      <a href="quiz.php" class="w3-button w3-block w3-orange w3-hover-red"><span style="text-decoration: none">TAKE THE QUIZ</span></a>
    </div>
  </div>
</div>

<!-- Header with image -->
<header class="w3-display-container" id="home" style="min-height:75%">
  <div class="w3-display-middle w3-center">
    <img src="Images/logo.png" alt="logo"><br />
    <span class="motto">~ BRING MANGA CLOSER TO YOU ~</span><br />
    <h5 class="button w3-block w3-orange w3-hover-red""><a href="quiz.php"><span style="text-decoration: none">Take the quiz</a></span></h5>
  </div>
</header>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-large" >

<!-- About Container -->
<div class="w3-container" id="about">
  <div class="w3-content" style="max-width:700px">
    <h4 class="w3-center w3-padding-64"><span class="w3-tag w3-wide">ABOUT THE APP</span></h4>
    <h5><u>Motivation & Aim</u></h5>
    <p>If you are a <strong>regular manga reader</strong>, sooner or later the time will come when you start to get bored of reading the same motif over and over again. You'd start to wander around the forums, looking for good recommendations for <b>new materials</b>, but sometimes it's such a chore.</p>
    <p>Or if you are interested in <strong>picking up manga</strong> as a new hobby, finding <b>where to start</b> is the first problem. Friends are the first ones you turn to, as they are probably also the one who introduced you to the manga world. But more often than not, <b>they don't know</b> what kind of materials you'd be into.</p>
    <p>The world of mangas is <strong>complex and expansive</strong>, even for experienced readers. Whether you want to start getting into mangas but don't know where to begin, or you're a veteran reader who just finished a series and want to try something different and fresh next, it's always a <b>hassle</b> to look for a new manga to pick up, especially one of a new genre.</p>
    <h5><u>Comparison to other implementations</u></h5>
    <p>At this moment, there are a few websites that recommend new manga for their users; however, most of these just require us to provide them with a list of our read mangas, and from there they will give us recommendations consist of mangas with similar style and genre. Hence, our app aims to assist a completely new reader or someone who wants to explore new materials, to cater them with interesting mangas that they might have thought that they wouldn't be able to enjoy (but actually do).</p>
  </div>
</div>

<!-- Features Container -->
<div class="w3-container" id="menu">
  <div class="w3-content" style="max-width:700px">
    <h4 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">FEATURES</span></h4>
    <img src="Images/poster.jpg" style="width:150%;max-width:1000px;margin-top:32px; margin-left:-21%">
    <p>Webpage interface with:
    <ul>
		<li>A login page to access their reading profile & recommendations for old users.</li>
		<li>A quiz for new users or those who do not want to sign-up.</li>
		<li>Offer a recommendation list after completion of quiz and options to signup to save their reading profile.</li>
		<li>For those with a signup profile, options to edit their reading preferences.</li>
		<li>Feedback system where users can rank and give review to Mangas which they were recommended. Mangas with higher ranking will have priority in the recommendation algorithm.</li>
		<li>Users' Manga review are also ranked by other users. Those with good reviews will have their feedback emphasized.</li>
    </ul></p>
    <p>A backend Database:
    <ul>
		<li>Data for the manga series are scraped from <a href="https://www.mangaupdates.com/">MangaUpdates</a> and <a href="https://myanimelist.net/">MyAnimeList</a></li>
		<li>Store past users' info, including profile, preferences and list of read mangas</li>
    </ul></p>
  </div>
</div>

<!-- Contact/Area Container -->
<div class="w3-container" id="team" style="padding-bottom:32px;">
  <div class="w3-content" style="max-width:700px">
    <h4 class="w3-center w3-padding-48"><span class="w3-tag w3-wide">TEAM</span></h4>
	<div class="row">
	  <div class="column">
	    <div class="card">
	      <img class="w3-circle w3-center" src="Images/Orbitee_1.jpg" alt="Jane" style="height:300px; display: block; margin: auto;" align="middle">
	      <div class="container">
	        <h2>Đào Quốc Cường</h2>
	        <p class="title">Erik</p>
	        <p>NUS student, AY16/17 Computer Science</p>
	        <p id="email1">e0053648@u.nus.edu</p>
	        <p><div class="popup" onclick="popup1()"><button class="contact" onclick="copy1()">Contact<span class="popuptext" id="popupText1">Email has been copied</span></button></div></p>
	      </div>
	    </div>
	  </div>
	
	  <div class="column">
	    <div class="card">
	      <img class="w3-circle w3-center" src="Images/Orbitee_2.jpg" alt="Mike" style="height:300px; display: block; margin: auto;" align="middle">
	      <div class="container">
	        <h2>Phạm Vũ Hưng</h2>
	        <p class="title">Leonid</p>
	        <p>NUS student, AY16/17 Computer Science</p>
	        <p id="email2">e0053652@u.nud.edu</p>
	        <p><div class="popup" onclick="popup2()"><button class="contact" onclick="copy2()">Contact<span class="popuptext" id="popupText2">Email has been copied</span></button></div></p>
	      </div>
	    </div>
	  </div>
	</div>
  </div>
</div>

<!-- End page content -->
</div>
<iframe id="hiddenFrame" name="hiddenFrame" style="display:none;"></iframe>
<div id="noticeSnackbar"></div>
<div id="feedbackModal" class="modal">
  
  <form class="modal-content animate" action="feedback.php" method="post" target="hiddenFrame">
    <h2 align="center">Feedback Form</h2>

    <div class="container">
      <label for="userName"><b>Username</b></label>
      <input type="text" id="userName" placeholder="Enter Username" name="userName" required>
      <?php 
        if ($user != "undefined") {
          echo "<script>document.getElementById('userName').value = '$user';</script>";
        }
      ?>

      <label for="NUS"><b>Are you a student of National University of Singapore?</b></label>
      <select id="NUS" name="NUS">
        <option value="yes">Yes</option>
        <option value="no">No</option>
        <option value="rather">Rather not say</option>
      </select>

      <label for="feedback">Feedback</label>
      <textarea id="feedback" name="feedback" placeholder="Write something.." style="height:200px" required></textarea>

      <button type="submit" onclick="setTimeout(showNotice, 100);document.getElementById('feedbackModal').style.display='none'">Submit</button>
    </div>
  </form>
</div>

<!-- Footer -->
<footer class="w3-center w3-light-grey w3-large" style="width:60%; padding:10px; margin:0 20%;">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" title="W3.CSS" target="_blank" class="w3-hover-text-green">w3.css</a></p>
</footer>
</body>
</html>

<script>
function copy1() {
	copyToClipboard(document.getElementById("email1"));
}

function copy2() {
	copyToClipboard(document.getElementById("email2"));
}

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}

function popup1() {
    var popup = document.getElementById("popupText1");
    popup.classList.toggle("show");
}

function popup2() {
    var popup = document.getElementById("popupText2");
    popup.classList.toggle("show");
}

var modal = document.getElementById('feedbackModal');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function showNotice() {
    // Get the snackbar DIV
    var frame = document.getElementById("hiddenFrame");
    var frameDocument = frame.contentDocument || frame.contentWindow.document;
    var text = frameDocument.body.innerHTML;
    if (text === "") {
      text = "Your feedback has been submitted. We thank you for your contribution.";
    }
    var notice = document.getElementById("noticeSnackbar");
    notice.innerHTML = text;
    // Add the "show" class to DIV
    notice.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ notice.className = notice.className.replace("show", ""); }, 5000);
}
</script>