<?php
ob_start();
session_start();
require_once 'pdo.php';
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>About Doggo Translate</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php require_once "head.php"; ?>
</head>
<body>


<nav class="navbar navbar-inverse">
<div class="container-fluid">
<div class="navbar-header">
<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
</button>
<a class="navbar-brand" href="index.php">Doggo Translate</a>
</div>
<div class="collapse navbar-collapse" id="myNavbar">
<ul class="nav navbar-nav">
  <li><a href="index.php">Home</a></li>
  <li class="active"><a href="#">About</a></li>
  <!-- <li><a href="login.php">Login</a></li> -->
  <?php
  if ( isset($_SESSION["name"]) ) {
      echo '<li><a href="view.php"> View Entries</a></li>';
      echo '<li><a href="add.php"> Add Entry</a></li>';
  }

   ?>
</ul>
<ul class="nav navbar-nav navbar-right">

  <?php
  if ( isset($_SESSION["name"]) && $_SESSION['user_id'] != 4 ) {
      echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Admin Logout</a></li>';
  }
  else if ( isset($_SESSION["name"]) && $_SESSION['user_id'] == 4) {
      echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Guest Logout</a></li>';
  }
  else {
      echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>';
  }
     ?>
</ul>
</div>
</div>
</nav>

<main>


<h1 style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.2));">About Doggo Translate</h1>

<hr>

<h3 style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.1));">The Internet's dogs are trying to communicate with you -
Doggo Translate can help!</h3>

<img src="images/beach3c.jpg" alt="Dogs playing on beach" class="img-rounded img-responsive" style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">

<hr>

<div class="column">

    <h3 class="text-center" style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.2));">What is DoggoLingo?</h3>
    <p><img src="images/rapids.jpg" alt="Dog standing in front of rapids" class="img-rounded" style="max-width:66%;height:auto;filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));"></p>
    <p>Dogs are surprisingly internet-savvy animals, and many have
    learned to use the web and online social media to communicate.</p>

    <p>Dogs however do not express themselves using the Queen's english -
    they use a dialect known as <em>DoggoLingo</em> (or <em>Doggo</em> for short).</p>

    <p>To the uninitiated <em>Hooman</em> - a term used by dogs to refer to humans -
    DoggoLingo may appear to be a string of cryptic, poorly spelled phrases in broken English -
    a common misconception among the uninformed!
    </p>

    <p>In reality, DoggoLingo is a surprisingly complex and sophisticated form of communication, and
    becoming an expert in DoggoLingo can take years if not decades of study.</p>
</div>

<div class="column">

    <h3 class="text-center" style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.2));">What is Doggo Translate?</h3>
    <p><img src="images/sunset.jpg" alt="Dog standing in front of forest sunset" class="img-rounded" style="max-width:66%;height:auto;filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));"><p>
    <p>For the benefit of all humankind (and dogkind for that matter) we have developed
    an easy to use web-based translation application utilizing the latest and most reputable scholarly research on comparative
    Doggo linguistics.</p>
    <p>
    <strong>Introducing Doggo Translate</strong> - the online rosetta-stone of human to canine communication!</p>

    <p><strong>Features include:</strong></p>
    <ul>
    <li>Easily translate from DoggoLingo to English, and English to DoggoLingo!</li>

    <li>Completely free to use!</li>

    <li>Use on your desktop, laptop, tablet or phone!</li>

    <li>As new terms are introduced into the DoggoLingo vernacular, Doggo Translate is capable of
    being updated by our team of world class DoggoLingo translation experts!!</li>
    </ul>


</div>

<div class="bottom">

<hr>
    <img src="images/beachbw2.jpg" alt="Dogs and human couple walking together on beach" class="img-rounded img-responsive" style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">

</div>

</main>
</body>
</html>
