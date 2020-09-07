<?php
ob_start();
require_once "pdo.php";
require_once "util.php";


session_start();

if ( ! isset($_SESSION['user_id']) )
{
    die('ACCESS DENIED');
    return;
}

if ( isset($_POST['cancel']))
{
    header('Location: view.php');
    return;
}

if ( isset($_POST['dkey']) && isset($_POST['dvalue']) ) {


         if ( strlen($_POST['dkey']) == 0 || strlen($_POST['dvalue']) == 0 ) {
             $_SESSION['error'] = "All fields are required";
             header("Location: add.php");
             return;
         }

         if ( $_SESSION['user_id'] == 4 ) {
             $_SESSION['error'] = "Guest cannot add entries";
             header("Location: view.php");
             return;
         }

        $stmt = $pdo->prepare('INSERT INTO doggo_dict
            (dkey, dvalue)
            VALUES ( :dk, :dv)');

    $stmt->execute(array(':dk' => $_POST['dkey'],':dv' => $_POST['dvalue'] ) );

    $_SESSION['success'] = 'Entry Added';
    header( "Location: http://doggo-translate.com/view.php" );
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Doggo Translate Admin - Add Entry</title>
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
      <li><a href="about.php">About</a></li>
      <?php
      if ( isset($_SESSION["name"]) ) {
          echo '<li><a href="view.php"> View Entries</a></li>';
          echo '<li class="active"><a href="add.php"> Add Entry</a></li>';
      }
       ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="login.php">Admin Login</a></li> -->
      <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
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
<h1 style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">Doggo Translate Admin - Add Entry</h1>
<hr>
<?php flashMessages(); ?>
<div class="form-group">
<form method="post" class="form-inline">
<!-- <p><strong>English word:</strong> -->
<label for="dkey" class="control-label">English Term: </label>
<input type="text" class="form-control form-horizontal" name="dkey" id="dkey" placeholder="Enter English Term" size="60"/>
<p></p>
<!-- <p><strong>Doggo word:</strong> -->
<label for="dvalue" class="control-label">Doggo Term:&nbsp; </label>
<input type="text" class="form-control form-horizontal" name="dvalue" id="dvalue" placeholder="Enter Doggo Term" size="60"/>
<p></p>
<input type="submit" class="form-control form-horizontal btn btn-primary" value="Add" onclick="return doValidate();">
<input type="submit" class="form-control form-horizontal btn btn-default" name="cancel" value="Cancel">
<p></p>
</form>
</div>

<script>

function doValidate() {
    console.log('Validating...');
    try {
        dkey = document.getElementById('dkey').value;
        dvalue = document.getElementById('dvalue').value;
        console.log("Validating dkey="+dkey+" dvalue="+dvalue);
        if (dkey == null || dkey == "" || dvalue == null || dvalue == "") {
            alert("Both fields must be filled out");
            return false;
        }
        return true;
        } catch (e) {
            return false;
    }
    return false;
}

</script>

<p>
<img src="images/beach2c.jpg" alt="Dogs playing on beach" class="img-rounded img-responsive" style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">
</p>

</main>


</body>
</html>
