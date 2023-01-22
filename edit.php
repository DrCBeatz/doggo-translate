<?php
ob_start();
require_once 'pdo.php';
require_once 'util.php';

session_start();

if( ! isset($_SESSION['user_id'])) {
    die("ACCESS DENIED");
    return;
}

if ( isset($_POST['cancel']) ) {
    header('Location: view.php');
    return;
}

if ( ! isset($_REQUEST['word_id']) ) {
    $_SESSION['error'] = "Missing word_id";
    header('Location: index.php');
    return;
}


$stmt = $pdo->prepare('SELECT * FROM doggo_dict WHERE word_id = :zip');
$stmt->execute(array( ':zip' => $_REQUEST['word_id'] ));
$word = $stmt->fetch(PDO::FETCH_ASSOC);
if ($word === false ) {
    $_SESSION['error'] = "Could not load word";
    header('Location: view.php');
    return;
}

if ( isset($_POST['dkey']) && isset($_POST['dvalue']) ) {

    if ( $_SESSION['user_id'] == 14 ) {
        $_SESSION['error'] = "Guest cannot edit entries";
        header("Location: view.php");
        return;
    }
         $stmt = $pdo->prepare('UPDATE doggo_dict SET dkey=:dk, dvalue=:dv WHERE word_id=:zip');
         $stmt->execute(array(':zip' => $_REQUEST['word_id'], ':dk' => $_POST['dkey'], ':dv' => $_POST['dvalue'] ) );

        $_SESSION['success'] = "Entry updated";
        header("Location: view.php");
        return;
     }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Doggo Translate Admin - Edit Entry</title>
<?php require_once "head.php"; ?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
      if ( isset($_SESSION["name"])  ) {
          echo '<li class="active"><a href="view.php"> View Entries</a></li>';
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
        <h1 style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">Doggo Translate Admin - Editing Entry</h1>
        <hr>
<?php

flashMessages();
?>
<form method="post" action="edit.php" class="form-inline">
<input type="hidden" class="form-control form-horizontal" name="word_id"
value="<?= htmlentities($_REQUEST['word_id']); ?>"
/>
<label for="dkey" class="control-label">English Term: </label>
<input type="text" class="form-control form-horizontal" name="dkey" id="dkey" size="60"
value="<?= htmlentities($word['dkey']); ?>"
/>
<p></p>
<label for="dvalue" class="control-label">Doggo Term:&nbsp; </label>
<input type="text" class="form-control form-horizontal" name="dvalue" id="dvalue" size="60"
value="<?= htmlentities($word['dvalue']); ?>"
/>
<p></p>
<input type = "submit" class="form-control form-horizontal btn btn-primary" value="Save" onclick="return doValidate();">
<input type = "submit" class="form-control form-horizontal btn btn-default" name="cancel" value="Cancel">
</form>

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

</main>
</body>
</html>
