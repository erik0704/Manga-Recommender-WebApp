<?php
  ob_start();
  if(!isset($_SESSION)) { 
    session_start(); 
  } 
?>
<!DOCTYPE html>
<html>
<title>Manga Preference Quiz</title>
<head> 
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:400,700">
  <script src="jquery-3.2.1.js"></script>
  <link rel="stylesheet" href="stylesheet.css">
</head>
<style>
h4 {
    font-family: "Wildwords", "Manga Temple", "Anime Ace 2", cursive, sans-serif;
}
h3 { 
  text-align: center;
  margin: 6%;
}
#quiz {
  height: 720px;
  width: 1000px;
}
.question{
  position: relative;
  height: 540px;
  max-width: 1000px;
  padding: 20px;
  border-radius: 10px;
  background-color: #d3ddd3;
  border: 1px solid #d3ddd3;
  display: none;
}
.question ul{
  list-style: none;
  margin: 0;
  padding: 0;
  overflow: auto;
}

.choice {
  width: 80%;
  margin: 5px 100px;
  background-color: #fdd1b7;
}
ul li{
  display: block;
  position: relative;
  float: left;
  width: 80%;
  margin: 5px 100px;
  background-color: #fdd1b7;

}
ul li input[type=radio]{
  position: absolute;
  visibility: hidden;
}
ul li label{
  display: block;
  position: relative;
  text-align: center;
  height: 45px;
  line-height: 45px;
  width:100%;
  cursor: pointer;
  overflow: hidden;
  -webkit-transition: all 0.15s linear;
}
span {
  margin-top:-5px;
  display: inline-block;
  vertical-align: middle;
  line-height: normal;
}
ul li:hover label{
  color: #FEFEFE;
}
input[type=radio]:checked ~ label{
  background-color: #ff9800;
}
input[type=radio]:checked ~ li{
  background-color: #ff9800;
}
input[type=submit] {
  width: 150px;
  margin:10px;
  cursor:pointer;
  -webkit-border-radius: 5px;
  border-radius: 5px; 
}
.total {
  height:  45px;
  width: 733px; /* Full width */
  background-color: #ddd; /* Grey background */
  box-sizing:border-box;
  margin: 10px 10px 0 10px;
}
.progressText {
  text-align: right; /* Right-align text */
  padding-right: 20px; /* Add some right padding */
  line-height: 40px; /* Set the line-height to center the text inside the skill bar, and to expand the height of the container */
  color: white; /* White text color */
}
.progress {
  height: 45px;
  width: 0%; 
  background-color: #062a1f;
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
}

/* Modal Content/Box */
.modal-content {
    background-color: #fefefe;
    margin: 20% auto; /* 15% from the top and centered */
    padding: 20px;
    border: 1px solid #888;
    width: 60%; /* Could be more or less, depending on screen size */
    text-align: center;
}

/* The Close Button */
.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
.close:hover, .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<body class="w3-display-container w3-sand" onload='displayModal("profileModal")'>
<!-- Links (sit on top) -->
<div class="w3-top">
  <div class="w3-row w3-padding w3-black">
    <div class="w3-col s2">
      <a href="index.php" class="w3-button w3-block w3-black">HOME</a>
    </div>
    <div class="w3-col s1" style="color:black">x</div>
    <div class="w3-col s6" align="middle"><img src="Images/alt_logo.png" alt="logo" style="height:38px;"></div>
    <div class="w3-col s1" style="color:black">x</div>
    <div class="w3-col s1">
      <a href="#about" class="w3-button w3-block w3-black">SIGN UP</a>
    </div>
    <div class="w3-col s1">
      <a href="#menu" class="w3-button w3-block w3-black">SIGN IN</a>
    </div>
  </div>
</div>

<!-- Add a background color and large text to the whole page -->
<div class="w3-sand w3-large">

  <!-- Quiz Container -->
  <div class="w3-display-middle">
    <form action="score_quiz.php" method="post" id="quiz">
      <h4>Manga Preference Quiz</h4>
      <div class="question" style="display:block" id="qn1">
        <h3>What is your gender?</h3>
        <ul>
          <li>
            <input type="radio" name="qn1-ans" id="qn1-ans-A" value="A" />
            <label for="qn1-ans-A" onclick="setTimeout(nextQn,200)"><span>Female</span></label>
          </li>
          <li>
            <input type="radio" name="qn1-ans" id="qn1-ans-B" value="B" />
            <label for="qn1-ans-B" onclick="setTimeout(nextQn,200)"><span>Male</span></label>
          </li>
          <li>
            <input type="radio" name="qn1-ans" id="qn1-ans-C" value="C" />
            <label for="qn1-ans-C" onclick="setTimeout(nextQn,200)"><span>Others</span></label>
          </li>
          <li>
            <input type="radio" name="qn1-ans" id="qn1-ans-D" value="D" checked />
            <label for="qn1-ans-D" onclick="setTimeout(nextQn,200)"><span>Rather not say</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn2">
        <h3>What is your age?</h3>
        <ul>
          <li>
            <input type="radio" name="qn2-ans" id="qn2-ans-A" value="A" />
            <label for="qn2-ans-A" onclick="setTimeout(nextQn,200)"><span>10 or below</span></label>
          </li>
          <li>
            <input type="radio" name="qn2-ans" id="qn2-ans-B" value="B" />
            <label for="qn2-ans-B" onclick="setTimeout(nextQn,200)"><span>11-20</span></label>
          </li>
          <li>
            <input type="radio" name="qn2-ans" id="qn2-ans-C" value="C" checked />
            <label for="qn2-ans-C" onclick="setTimeout(nextQn,200)"><span>21-30</span></label>
          </li>
          <li>
            <input type="radio" name="qn2-ans" id="qn2-ans-D" value="D" />
            <label for="qn2-ans-D" onclick="setTimeout(nextQn,200)"><span>31-40</span></label>
          </li>
          <li>
            <input type="radio" name="qn2-ans" id="qn2-ans-E" value="E" />
            <label for="qn2-ans-E" onclick="setTimeout(nextQn,200)"><span>40+</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn3">
        <h3>In a typical week, about how many days do you spend at least 30 minutes reading manga?</h3>
        <ul>
          <li>
            <input type="radio" name="qn3-ans" id="qn3-ans-A" value="A" checked />
            <label for="qn3-ans-A" onclick="setTimeout(nextQn,200)"><span>0-1 day</span></label>
          </li>
          <li>
            <input type="radio" name="qn3-ans" id="qn3-ans-B" value="B" />
            <label for="qn3-ans-B" onclick="setTimeout(nextQn,200)"><span>2-3 days</span></label>
          </li>
          <li>
            <input type="radio" name="qn3-ans" id="qn3-ans-C" value="C" />
            <label for="qn3-ans-C" onclick="setTimeout(nextQn,200)"><span>4-5 days</span></label>
          </li>
          <li>
            <input type="radio" name="qn3-ans" id="qn3-ans-D" value="D" />
            <label for="qn3-ans-D" onclick="setTimeout(nextQn,200)"><span>6-7 days</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn4">
        <h3>Would you consider yourself to be a...</h3>
        <ul>
          <li>
            <input type="radio" name="qn4-ans" id="qn4-ans-A" value="A" />
            <label for="qn4-ans-A" onclick="setTimeout(nextQn,200)" style="height:80px;line-height: 80px"><span>Newbie manga reader <br /><sub>i.e. you just started reading 0-2 series</span></label>
          </li>
          <li>
            <input type="radio" name="qn4-ans" id="qn4-ans-B" value="B" checked />
            <label for="qn4-ans-B" onclick="setTimeout(nextQn,200)" style="height:80px;line-height: 80px"><span>Casual manga reader <br /><sub>i.e. you dabble in mangas, but short sessions or infrequently</span></label>
          </li>
          <li>
            <input type="radio" name="qn4-ans" id="qn4-ans-C" value="C" />
            <label for="qn4-ans-C" onclick="setTimeout(nextQn,200)" style="height:80px;line-height: 80px"><span>Softcore manga reader <br /><sub>i.e. you've read quite a number of series (25+), and can sit still for more than an hour, only reading manga</span></label>
          </li>
          <li>
            <input type="radio" name="qn4-ans" id="qn4-ans-D" value="D" />
            <label for="qn4-ans-D" onclick="setTimeout(nextQn,200)" style="height:80px;line-height: 80px"><span>Hardcore manga reader <br /><sub>i.e. you've read a lot of mangas (50+), actively follow some ongoing series, and maybe even look for doujin</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn5">
        <h3>How do you normally read manga?</h3>
        <ul>
          <li>
            <input type="radio" name="qn5-ans" id="qn5-ans-A" value="A" />
            <label for="qn5-ans-A" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('factorsModal');}, 200)"><span>Buying hard copies</span></label>
          </li>
          <li>
            <input type="radio" name="qn5-ans" id="qn5-ans-B" value="B" />
            <label for="qn5-ans-B" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('factorsModal');}, 200)"><span>Using phones/tablets</span></label>
          </li>
          <li>
            <input type="radio" name="qn5-ans" id="qn5-ans-C" value="C" checked />
            <label for="qn5-ans-C" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('factorsModal');}, 200)"><span>Using desktop/laptop</span></label>
          </li>
          <li>
            <input type="radio" name="qn5-ans" id="qn5-ans-D" value="D" />
            <label for="qn5-ans-D" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('factorsModal');}, 200)"><span>I have never/don't usually read manga</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn6">
        <h3>Characters having feelings for each other</h3>
        <ul>
          <li>
            <input type="radio" name="qn6-ans" id="qn6-ans-A" value="A" />
            <label for="qn6-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn6-ans" id="qn6-ans-B" value="B" />
            <label for="qn6-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn6-ans" id="qn6-ans-C" value="C" checked />
            <label for="qn6-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn6-ans" id="qn6-ans-D" value="D" />
            <label for="qn6-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn6-ans" id="qn6-ans-E" value="E" />
            <label for="qn6-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn7">
        <h3>Plot twist</h3>
        <ul>
          <li>
            <input type="radio" name="qn7-ans" id="qn7-ans-A" value="A" />
            <label for="qn7-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn7-ans" id="qn7-ans-B" value="B" />
            <label for="qn7-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn7-ans" id="qn7-ans-C" value="C" checked />
            <label for="qn7-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn7-ans" id="qn7-ans-D" value="D" />
            <label for="qn7-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn7-ans" id="qn7-ans-E" value="E" />
            <label for="qn7-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn8">
        <h3>Having a driving force that keeps the plot going</h3>
        <ul>
          <li>
            <input type="radio" name="qn8-ans" id="qn8-ans-A" value="A" />
            <label for="qn8-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn8-ans" id="qn8-ans-B" value="B" />
            <label for="qn8-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn8-ans" id="qn8-ans-C" value="C" checked />
            <label for="qn8-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn8-ans" id="qn8-ans-D" value="D" />
            <label for="qn8-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn8-ans" id="qn8-ans-E" value="E" />
            <label for="qn8-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn9">
        <h3>Characters with intriguing background</h3>
        <ul>
          <li>
            <input type="radio" name="qn9-ans" id="qn9-ans-A" value="A" />
            <label for="qn9-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn9-ans" id="qn9-ans-B" value="B" />
            <label for="qn9-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn9-ans" id="qn9-ans-C" value="C" checked />
            <label for="qn9-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn9-ans" id="qn9-ans-D" value="D" />
            <label for="qn9-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn9-ans" id="qn9-ans-E" value="E" />
            <label for="qn9-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn10">
        <h3>A realistic, down-to-earth settings and development</h3>
        <ul>
          <li>
            <input type="radio" name="qn10-ans" id="qn10-ans-A" value="A" />
            <label for="qn10-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn10-ans" id="qn10-ans-B" value="B" />
            <label for="qn10-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn10-ans" id="qn10-ans-C" value="C" checked />
            <label for="qn10-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn10-ans" id="qn10-ans-D" value="D" />
            <label for="qn10-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn10-ans" id="qn10-ans-E" value="E" />
            <label for="qn10-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn11">
        <h3>Characters with sultry appearance, and/or are sometimes caught in sexy poses/situations</h3>
        <ul>
          <li>
            <input type="radio" name="qn11-ans" id="qn11-ans-A" value="A" />
            <label for="qn11-ans-A" onclick="setTimeout(nextQn,200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn11-ans" id="qn11-ans-B" value="B" />
            <label for="qn11-ans-B" onclick="setTimeout(nextQn,200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn11-ans" id="qn11-ans-C" value="C" checked />
            <label for="qn11-ans-C" onclick="setTimeout(nextQn,200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn11-ans" id="qn11-ans-D" value="D" />
            <label for="qn11-ans-D" onclick="setTimeout(nextQn,200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn11-ans" id="qn11-ans-E" value="E" />
            <label for="qn11-ans-E" onclick="setTimeout(nextQn,200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn12">
        <h3>Sense of humor</h3>
        <ul>
          <li>
            <input type="radio" name="qn12-ans" id="qn12-ans-A" value="A" />
            <label for="qn12-ans-A" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('scenariModal');}, 200)"><span>Not at all important</span></label>
          </li>
          <li>
            <input type="radio" name="qn12-ans" id="qn12-ans-B" value="B" />
            <label for="qn12-ans-B" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('scenariModal');}, 200)"><span>Slightly important</span></label>
          </li>
          <li>
            <input type="radio" name="qn12-ans" id="qn12-ans-C" value="C" checked />
            <label for="qn12-ans-C" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('scenariModal');}, 200)"><span>Somewhat important</span></label>
          </li>
          <li>
            <input type="radio" name="qn12-ans" id="qn12-ans-D" value="D" />
            <label for="qn12-ans-D" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('scenariModal');}, 200)"><span>Very important</span></label>
          </li>
          <li>
            <input type="radio" name="qn12-ans" id="qn12-ans-E" value="E" />
            <label for="qn12-ans-E" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('scenariModal');}, 200)"><span>Extremely important</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn13">
        <h3>A seemingly regular protagonist suddenly discovers that he/she has dormant power, or is bestowed upon</h3>
        <ul>
          <li>
            <input type="radio" name="qn13-ans" id="qn13-ans-A" value="A" />
            <label for="qn13-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn13-ans" id="qn13-ans-B" value="B" />
            <label for="qn13-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn13-ans" id="qn13-ans-C" value="C" checked />
            <label for="qn13-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn13-ans" id="qn13-ans-D" value="D" />
            <label for="qn13-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn13-ans" id="qn13-ans-E" value="E" />
            <label for="qn13-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn14">
        <h3>Main characters are trapped and isolated for undisclosed reasons, and they are in danger</h3>
        <ul>
          <li>
            <input type="radio" name="qn14-ans" id="qn14-ans-A" value="A" />
            <label for="qn14-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn14-ans" id="qn14-ans-B" value="B" />
            <label for="qn14-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn14-ans" id="qn14-ans-C" value="C" checked />
            <label for="qn14-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn14-ans" id="qn14-ans-D" value="D" />
            <label for="qn14-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn14-ans" id="qn14-ans-E" value="E" />
            <label for="qn14-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn15">
        <h3>Protagonist is in a sport team, or joins at the start of the series, and they compete for the top</h3>
        <ul>
          <li>
            <input type="radio" name="qn15-ans" id="qn15-ans-A" value="A" />
            <label for="qn15-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn15-ans" id="qn15-ans-B" value="B" />
            <label for="qn15-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn15-ans" id="qn15-ans-C" value="C" checked />
            <label for="qn15-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn15-ans" id="qn15-ans-D" value="D" />
            <label for="qn15-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn15-ans" id="qn15-ans-E" value="E" />
            <label for="qn15-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn16">
        <h3>Protagonist wakes up to find himself/herself in another world</h3>
        <ul>
          <li>
            <input type="radio" name="qn16-ans" id="qn16-ans-A" value="A" />
            <label for="qn16-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn16-ans" id="qn16-ans-B" value="B" />
            <label for="qn16-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn16-ans" id="qn16-ans-C" value="C" checked />
            <label for="qn16-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn16-ans" id="qn16-ans-D" value="D" />
            <label for="qn16-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn16-ans" id="qn16-ans-E" value="E" />
            <label for="qn16-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn17">
        <h3>The lead character(s) makes big deal out of everything, even the most trivial, unremarkable encounters</h3>
        <ul>
          <li>
            <input type="radio" name="qn17-ans" id="qn17-ans-A" value="A" />
            <label for="qn17-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn17-ans" id="qn17-ans-B" value="B" />
            <label for="qn17-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn17-ans" id="qn17-ans-C" value="C" checked />
            <label for="qn17-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn17-ans" id="qn17-ans-D" value="D" />
            <label for="qn17-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn17-ans" id="qn17-ans-E" value="E" />
            <label for="qn17-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn18">
        <h3>A man is the dorm-father of an all-girl dormitory</h3>
        <ul>
          <li>
            <input type="radio" name="qn18-ans" id="qn18-ans-A" value="A" />
            <label for="qn18-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn18-ans" id="qn18-ans-B" value="B" />
            <label for="qn18-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn18-ans" id="qn18-ans-C" value="C" checked />
            <label for="qn18-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn18-ans" id="qn18-ans-D" value="D" />
            <label for="qn18-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn18-ans" id="qn18-ans-E" value="E" />
            <label for="qn18-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn19">
        <h3>A boy accidentally discovers a popular girl’s secret, one that she doesn’t want anyone to know about</h3>
        <ul>
          <li>
            <input type="radio" name="qn19-ans" id="qn19-ans-A" value="A" />
            <label for="qn19-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn19-ans" id="qn19-ans-B" value="B" />
            <label for="qn19-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn19-ans" id="qn19-ans-C" value="C" checked />
            <label for="qn19-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn19-ans" id="qn19-ans-D" value="D" />
            <label for="qn19-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn19-ans" id="qn19-ans-E" value="E" />
            <label for="qn19-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn20">
        <h3>Science has greatly improved the quality-of-life, but there are also people who are abusing it, and it’s up to the protagonist to deal with them</h3>
        <ul>
          <li>
            <input type="radio" name="qn20-ans" id="qn20-ans-A" value="A" />
            <label for="qn20-ans-A" onclick="setTimeout(nextQn,200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn20-ans" id="qn20-ans-B" value="B" />
            <label for="qn20-ans-B" onclick="setTimeout(nextQn,200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn20-ans" id="qn20-ans-C" value="C" checked />
            <label for="qn20-ans-C" onclick="setTimeout(nextQn,200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn20-ans" id="qn20-ans-D" value="D" />
            <label for="qn20-ans-D" onclick="setTimeout(nextQn,200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn20-ans" id="qn20-ans-E" value="E" />
            <label for="qn20-ans-E" onclick="setTimeout(nextQn,200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn21">
        <h3>Friends are pitted against one another on a battle of wits</h3>
        <ul>
          <li>
            <input type="radio" name="qn21-ans" id="qn21-ans-A" value="A" />
            <label for="qn21-ans-A" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('occurreModal');}, 200)"><span>Hate it</span></label>
          </li>
          <li>
            <input type="radio" name="qn21-ans" id="qn21-ans-B" value="B" />
            <label for="qn21-ans-B" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('occurreModal');}, 200)"><span>Acceptable, don't really enjoy</span></label>
          </li>
          <li>
            <input type="radio" name="qn21-ans" id="qn21-ans-C" value="C" checked />
            <label for="qn21-ans-C" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('occurreModal');}, 200)"><span>Enjoy somewhat</span></label>
          </li>
          <li>
            <input type="radio" name="qn21-ans" id="qn21-ans-D" value="D" />
            <label for="qn21-ans-D" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('occurreModal');}, 200)"><span>Enjoy a lot</span></label>
          </li>
          <li>
            <input type="radio" name="qn21-ans" id="qn21-ans-E" value="E" />
            <label for="qn21-ans-E" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('occurreModal');}, 200)"><span>Love it</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn22">
        <h3>Which one do you prefer to be the lead character(s)?</h3>
        <ul>
          <li>
            <input type="radio" name="qn22-ans" id="qn22-ans-A" value="A" />
            <label for="qn22-ans-A" onclick="setTimeout(nextQn,200)"><span>Female</span></label>
          </li>
          <li>
            <input type="radio" name="qn22-ans" id="qn22-ans-B" value="B" />
            <label for="qn22-ans-B" onclick="setTimeout(nextQn,200)"><span>Male</span></label>
          </li>
          <li>
            <input type="radio" name="qn22-ans" id="qn22-ans-C" value="C" />
            <label for="qn22-ans-C" onclick="setTimeout(nextQn,200)"><span>Both</span></label>
          </li>
          <li>
            <input type="radio" name="qn22-ans" id="qn22-ans-D" value="D" />
            <label for="qn22-ans-D" onclick="setTimeout(nextQn,200)"><span>None. I prefer Aliens</span></label>
          </li>
          <li>
            <input type="radio" name="qn22-ans" id="qn22-ans-E" value="E" checked />
            <label for="qn22-ans-E" onclick="setTimeout(nextQn,200)"><span>Doesn't matter</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn23">
        <h3>Which of the following characteristic would you prefer the lead protagonist to be?</h3>
        <ul>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-A" value="A" />
            <label for="qn23-ans-A" onclick="setTimeout(nextQn,200)"><span>Smart</span></label>
          </li>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-B" value="B" />
            <label for="qn23-ans-B" onclick="setTimeout(nextQn,200)"><span>Strong</span></label>
          </li>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-C" value="C" />
            <label for="qn23-ans-C" onclick="setTimeout(nextQn,200)"><span>Popular</span></label>
          </li>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-D" value="D" />
            <label for="qn23-ans-D" onclick="setTimeout(nextQn,200)"><span>Beautiful/Handsome</span></label>
          </li>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-E" value="E" />
            <label for="qn23-ans-E" onclick="setTimeout(nextQn,200)"><span>Young</span></label>
          </li>
          <li>
            <input type="radio" name="qn23-ans" id="qn23-ans-F" value="F" checked />
            <label for="qn23-ans-F" onclick="setTimeout(nextQn,200)"><span>Doesn't matter</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn24">
        <h3>In a romance manga, what do you think of a love triangle/polygon?</h3>
        <ul>
          <li>
            <input type="radio" name="qn24-ans" id="qn24-ans-A" value="A" />
            <label for="qn24-ans-A" onclick="setTimeout(nextQn,200)"><span>Good, since it spices things up</span></label>
          </li>
          <li>
            <input type="radio" name="qn24-ans" id="qn24-ans-B" value="B" />
            <label for="qn24-ans-B" onclick="setTimeout(nextQn,200)"><span>I prefer reading vanilla romance, i.e. no 3rd person</span></label>
          </li>
          <li>
            <input type="radio" name="qn24-ans" id="qn24-ans-C" value="C" checked />
            <label for="qn24-ans-C" onclick="setTimeout(nextQn,200)"><span>I don’t mind it either way</span></label>
          </li>
          <li>
            <input type="radio" name="qn24-ans" id="qn24-ans-D" value="D" />
            <label for="qn24-ans-D" onclick="setTimeout(nextQn,200)"><span>I don’t read romance manga</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn25">
        <h3>For the two main characters in a romance manga, how do you like them to be?</h3>
        <ul>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-A" value="A" />
            <label for="qn25-ans-A" onclick="setTimeout(nextQn,200)"><span>They were childhood friends</span></label>
          </li>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-B" value="B" checked />
            <label for="qn25-ans-B" onclick="setTimeout(nextQn,200)"><span>They were classmates (not childhood friends)</span></label>
          </li>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-C" value="C" />
            <label for="qn25-ans-C" onclick="setTimeout(nextQn,200)"><span>They are each other’s first lover</span></label>
          </li>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-D" value="D" />
            <label for="qn25-ans-D" onclick="setTimeout(nextQn,200)"><span>They never get together (wtf man)</span></label>
          </li>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-E" value="E" />
            <label for="qn25-ans-E" onclick="setTimeout(nextQn,200)"><span>One (or both) has an affair (I dun even)</span></label>
          </li>
          <li>
            <input type="radio" name="qn25-ans" id="qn25-ans-F" value="F" />
            <label for="qn25-ans-F" onclick="setTimeout(nextQn,200)"><span>I don't read romance manga</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn26">
        <h3>Do you have problems with violent content?</h3>
        <ul>
          <li>
            <input type="radio" name="qn26-ans" id="qn26-ans-A" value="A" />
            <label for="qn26-ans-A" onclick="setTimeout(nextQn,200)"><span>I enjoy reading it</span></label>
          </li>
          <li>
            <input type="radio" name="qn26-ans" id="qn26-ans-B" value="B" checked />
            <label for="qn26-ans-B" onclick="setTimeout(nextQn,200)"><span>I don’t have a problem with reading it</span></label>
          </li>
          <li>
            <input type="radio" name="qn26-ans" id="qn26-ans-C" value="C" />
            <label for="qn26-ans-C" onclick="setTimeout(nextQn,200)"><span>I do not want to read such mangas</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn27">
        <h3>What about graphic/gory content?</h3>
        <ul>
          <li>
            <input type="radio" name="qn27-ans" id="qn27-ans-A" value="A" />
            <label for="qn27-ans-A" onclick="setTimeout(nextQn,200)"><span>I enjoy reading it</span></label>
          </li>
          <li>
            <input type="radio" name="qn27-ans" id="qn27-ans-B" value="B" checked />
            <label for="qn27-ans-B" onclick="setTimeout(nextQn,200)"><span>I don’t have a problem with reading it</span></label>
          </li>
          <li>
            <input type="radio" name="qn27-ans" id="qn27-ans-C" value="C" />
            <label for="qn27-ans-C" onclick="setTimeout(nextQn,200)"><span>I do not want to read such mangas</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn28">
        <h3>What time period do you prefer the setting to be in?</h3>
        <ul>
          <li>
            <input type="radio" name="qn28-ans" id="qn28-ans-A" value="A" />
            <label for="qn28-ans-A" onclick="setTimeout(nextQn,200)"><span>21st century</span></label>
          </li>
          <li>
            <input type="radio" name="qn28-ans" id="qn28-ans-B" value="B" />
            <label for="qn28-ans-B" onclick="setTimeout(nextQn,200)"><span>Before that</span></label>
          </li>
          <li>
            <input type="radio" name="qn28-ans" id="qn28-ans-C" value="C" />
            <label for="qn28-ans-C" onclick="setTimeout(nextQn,200)"><span>After that</span></label>
          </li>
          <li>
            <input type="radio" name="qn28-ans" id="qn28-ans-D" value="D" checked />
            <label for="qn28-ans-D" onclick="setTimeout(nextQn,200)"><span>Doesn't matter when (it's always a good time then)</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn29">
        <h3>Do you believe in <a href="https://www.youtube.com/watch?v=mDYNuD4CwlI" target="_blank">magic</a>?</h3>
        <ul>
          <li>
            <input type="radio" name="qn29-ans" id="qn29-ans-A" value="A" />
            <label for="qn29-ans-A" onclick="setTimeout(nextQn,200)"><span>Hell yeah</span></label>
          </li>
          <li>
            <input type="radio" name="qn29-ans" id="qn29-ans-B" value="B" />
            <label for="qn29-ans-B" onclick="setTimeout(nextQn,200)"><span>Nein</span></label>
          </li>
          <li>
            <input type="radio" name="qn29-ans" id="qn29-ans-C" value="C" checked />
            <label for="qn29-ans-C" onclick="setTimeout(nextQn,200)"><span>Whatever floats the author's boat</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn30">
        <h3>A little bit of mythical foes along the way?</h3>
        <ul>
          <li>
            <input type="radio" name="qn30-ans" id="qn30-ans-A" value="A" />
            <label for="qn30-ans-A" onclick="setTimeout(nextQn,200)"><span>Would be lovely</span></label>
          </li>
          <li>
            <input type="radio" name="qn30-ans" id="qn30-ans-B" value="B" />
            <label for="qn30-ans-B" onclick="setTimeout(nextQn,200)"><span>I'll pass</span></label>
          </li>
          <li>
            <input type="radio" name="qn30-ans" id="qn30-ans-C" value="C" checked />
            <label for="qn30-ans-C" onclick="setTimeout(nextQn,200)"><span>Surprise me</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn31">
        <h3>Should characters be just normal human?</h3>
        <ul>
          <li>
            <input type="radio" name="qn31-ans" id="qn31-ans-A" value="A" />
            <label for="qn31-ans-A" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('miscellModal');}, 200)"><span>Yes, I can relate more to their problems and drama</span></label>
          </li>
          <li>
            <input type="radio" name="qn31-ans" id="qn31-ans-B" value="B" />
            <label for="qn31-ans-B" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('miscellModal');}, 200)"><span>No that would be boring</span></label>
          </li>
          <li>
            <input type="radio" name="qn31-ans" id="qn31-ans-C" value="C" checked />
            <label for="qn31-ans-C" onclick="setTimeout(nextQn,200); setTimeout(function() {displayModal('miscellModal');}, 200)"><span>Anything goes</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn32">
        <h3>Which among this do/would you like the most?</h3>
        <ul>
          <li>
            <input type="radio" name="qn32-ans" id="qn32-ans-A" value="A" checked />
            <label for="qn32-ans-A" onclick="setTimeout(nextQn,200)"><span>Two characters you are rooting for finally confess and kiss...aww...</span></label>
          </li>
          <li>
            <input type="radio" name="qn32-ans" id="qn32-ans-B" value="B" />
            <label for="qn32-ans-B" onclick="setTimeout(nextQn,200)"><span>Two bitter enemies fight, and one side finally has a decisive victory!</span></label>
          </li>
          <li>
            <input type="radio" name="qn32-ans" id="qn32-ans-C" value="C" />
            <label for="qn32-ans-C" onclick="setTimeout(nextQn,200)"><span>The underdog proves himself against the almighty character!!</span></label>
          </li>
          <li>
            <input type="radio" name="qn32-ans" id="qn32-ans-D" value="D" />
            <label for="qn32-ans-D" onclick="setTimeout(nextQn,200)"><span>Something stupid and funny happens that you can't help clutch your stomach laughing</span></label>
          </li>
          <li>
            <input type="radio" name="qn32-ans" id="qn32-ans-E" value="E" />
            <label for="qn32-ans-E" onclick="setTimeout(nextQn,200)"><span>The character you hate so much FINALLY dies/sees justice!!! MUWHAHA</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn33">
        <h3>When a character says “What is this feeling?”, what do you think that feeling is?</h3>
        <ul>
          <li>
            <input type="radio" name="qn33-ans" id="qn33-ans-A" value="A" />
            <label for="qn33-ans-A" onclick="setTimeout(nextQn,200)"><span>A new power</span></label>
          </li>
          <li>
            <input type="radio" name="qn33-ans" id="qn33-ans-B" value="B" checked />
            <label for="qn33-ans-B" onclick="setTimeout(nextQn,200)"><span>An unknown/unseen entity is nearby</span></label>
          </li>
          <li>
            <input type="radio" name="qn33-ans" id="qn33-ans-C" value="C" />
            <label for="qn33-ans-C" onclick="setTimeout(nextQn,200)"><span>Boobs (lmao)</span></label>
          </li>
          <li>
            <input type="radio" name="qn33-ans" id="qn33-ans-D" value="D" />
            <label for="qn33-ans-D" onclick="setTimeout(nextQn,200)"><span>A omen for something bad is going to happen</span></label>
          </li>
          <li>
            <input type="radio" name="qn33-ans" id="qn33-ans-E" value="E" />
            <label for="qn33-ans-E" onclick="setTimeout(nextQn,200)"><span>Love/Jealousy</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn34">
        <h3>Immortality for oneself would be...</h3>
        <ul>
          <li>
            <input type="radio" name="qn34-ans" id="qn34-ans-A" value="A" />
            <label for="qn34-ans-A" onclick="setTimeout(nextQn,200)"><span>A curse</span></label>
          </li>
          <li>
            <input type="radio" name="qn34-ans" id="qn34-ans-B" value="B" />
            <label for="qn34-ans-B" onclick="setTimeout(nextQn,200)"><span>A blessing</span></label>
          </li>
          <li>
            <input type="radio" name="qn34-ans" id="qn34-ans-C" value="C" checked />
            <label for="qn34-ans-C" onclick="setTimeout(nextQn,200)"><span>Boring</span></label>
          </li>
          <li>
            <input type="radio" name="qn34-ans" id="qn34-ans-D" value="D" checked />
            <label for="qn34-ans-D" onclick="setTimeout(nextQn,200)"><span>Nothing in particular</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn35">
        <h3>You awaken in a dying, unfamiliar world. You discover that you were summoned to be the savior. So you...</h3>
        <ul>
          <li>
            <input type="radio" name="qn35-ans" id="qn35-ans-A" value="A" />
            <label for="qn35-ans-A" onclick="setTimeout(nextQn,200)"><span>Wait it out try to survive</span></label>
          </li>
          <li>
            <input type="radio" name="qn35-ans" id="qn35-ans-B" value="B" />
            <label for="qn35-ans-B" onclick="setTimeout(nextQn,200)"><span>Save the world, either alone or with a party</span></label>
          </li>
          <li>
            <input type="radio" name="qn35-ans" id="qn35-ans-C" value="C" />
            <label for="qn35-ans-C" onclick="setTimeout(nextQn,200)"><span>Seek to develop relations with the people around, maybe even romantic ones</span></label>
          </li>
          <li>
            <input type="radio" name="qn35-ans" id="qn35-ans-D" value="D" />
            <label for="qn35-ans-D" onclick="setTimeout(nextQn,200)"><span>Try your best to return to your own world</span></label>
          </li>
          <li>
            <input type="radio" name="qn35-ans" id="qn35-ans-E" value="E" checked />
            <label for="qn35-ans-E" onclick="setTimeout(nextQn,200)"><span>Have as much fun as possible</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="qn36">
        <h3>What kind of relationship between characters do/would you enjoy the most</h3>
        <ul>
          <li>
            <input type="radio" name="qn36-ans" id="qn36-ans-A" value="A" />
            <label for="qn36-ans-A" onclick="setTimeout(nextQn,200)"><span>Friendship</span></label>
          </li>
          <li>
            <input type="radio" name="qn36-ans" id="qn36-ans-B" value="B" checked />
            <label for="qn36-ans-B" onclick="setTimeout(nextQn,200)"><span>Crush/Love</span></label>
          </li>
          <li>
            <input type="radio" name="qn36-ans" id="qn36-ans-C" value="C" />
            <label for="qn36-ans-C" onclick="setTimeout(nextQn,200)"><span>Teammates/Comrades</span></label>
          </li>
          <li>
            <input type="radio" name="qn36-ans" id="qn36-ans-D" value="D" />
            <label for="qn36-ans-D" onclick="setTimeout(nextQn,200)"><span>Superior - Subordinate</span></label>
          </li>
          <li>
            <input type="radio" name="qn36-ans" id="qn36-ans-E" value="E" />
            <label for="qn36-ans-E" onclick="setTimeout(nextQn,200)"><span>Rivals/Enemies/Nemesis</span></label>
          </li>
        </ul>
      </div>
      <div class="question" id="quizRes" align="middle">
        <h3>QUIZ RESULTS</h3>
        <p>Please wait a moment while we compile your profile... <br /></p>
        <div class="loader"></div>
      </div>

    <!--Navigation bar -->
    <div id="navBar" style="display:block">
      <div onclick="prevQn()" class="w3-button w3-orange w3-hover-red" style="width:120px">&laquo; Previous</div>
      <div class="total" style="display:inline-block;"><div class="progress progressText" id="progress">0%</div></div>
      <div onclick="nextQn()" class="w3-button w3-green w3-hover-teal" style="width:120px">Next &raquo;</div>
    </div>
    <div class="w3-middle" align="middle" id="submitButton" style="display:none"><input class="w3-button w3-blue w3-hover-cyan" type="submit" value="Submit" onclick="submitForm()" /></div>
    </form>
  </div>

  <!-- Modals -->
  <div id="profileModal" class="modal">
    <div class="modal-content">
      <span class="close" id="profileClose">&times;</span>
      <p>This part of the quiz will try to place you into the appropriate demographic</p>
      <p>Note: For the whole quiz, we took the liberty to pre-select the neutral answers for you, where applicable.<br/>Feel free to reselect your answer, or leave it as it is.</p>
    </div>
  </div>
  <div id="factorsModal" class="modal">
    <div class="modal-content">
      <span class="close" id="factorsClose">&times;</span>
      <p>Now we'll start to figure out what kind of manga you may like to read</p>
      <p>First off, we will list a number of factors of a manga. Rate each factor based on how important you think it is for a good manga.</p>
    </div>
  </div>
  <div id="scenariModal" class="modal">
    <div class="modal-content">
      <span class="close" id="scenariClose">&times;</span>
      <p>Next, we will present a range of scenarios and settings of a manga</p>
      <p>Rate each scenario based on how much do/would you enjoy it.</p>
    </div>
  </div>
  <div id="occurreModal" class="modal">
    <div class="modal-content">
      <span class="close" id="occurreClose">&times;</span>
      <p>Next, we will show several categories (not genres) for a manga</p>
      <p>Rate each category based on how much do/would you enjoy it.</p>
    </div>
  </div>
  <div id="miscellModal" class="modal">
    <div class="modal-content">
      <span class="close" id="miscellClose">&times;</span>
      <p>Lastly, we will ask a few miscellanous questions that are related to your manga interest</p>
      <p>Choose answer for each question appropriately, as the answers are no longer uniform</p>
    </div>
  </div>

<!-- End page content -->
</div>

<!-- Footer -->
<footer class="w3-bottom w3-center w3-light-grey w3-large" id="TeamLeorik">
  <p>Created by <em>Team Leorik</em></a></p>
</footer>
</body>
</html>

<script>
var current = 1;
var total = 36;
var progressBar = document.getElementById("progress");
function nextQn() {
  if (current === total) {
    document.getElementById("submitButton").style.display = 'block';
    document.getElementById("TeamLeorik").style.display = 'none';
    var progValue = "100%";
    current = total;
    progressBar.innerHTML = progValue;
    progressBar.style.width = progValue;
  } else {
    var progValue = Math.round(current/total*100) + "%";
    toggleDisplay(document.getElementById("qn" + current));
    current++;
    toggleDisplay(document.getElementById("qn" + current));
    progressBar.innerHTML = progValue;
    progressBar.style.width = progValue;
  }
}

function prevQn() {
  if (current === 1)
    return;
  var progValue = Math.round(current/total*100) + "%";
  toggleDisplay(document.getElementById("qn" + current));
  current--;
  toggleDisplay(document.getElementById("qn" + current));
  var progValue = Math.round(current/total*100) + "%";
  var progressBar = document.getElementById("progress");
  progressBar.innerHTML = progValue;
  progressBar.style.width = progValue;
}

function toggleDisplay(elem) {
    if (elem.style.display === 'block') {
        elem.style.display = 'none';
    } else {
        elem.style.display = 'block';
    }
}

function submitForm() {
  var progValue = "100%";
  progressBar.innerHTML = progValue;
  progressBar.style.width = progValue;
  toggleDisplay(document.getElementById("qn" + current));
  toggleDisplay(document.getElementById("quizRes"));
  toggleDisplay(document.getElementById("navBar"));
  toggleDisplay(document.getElementById("submitButton"));
}

var modal;
var span;
function displayModal(modalID) {
  modal = document.getElementById(modalID);
  span = document.getElementById(modalID.substr(0,7) + "Close");
  modal.style.display = "block";
  span.onclick = function() {
    modal.style.display = "none";
  }
  window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
  }
}

</script>
<?php ob_end_flush(); ?>