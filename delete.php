<?php
ob_start();
require_once "pdo.php";

session_start();
if ( ! isset($_SESSION['name']) )
{
    die('Not logged in');
}

if ( isset($_POST['cancel']))
{
    header('Location: view.php');
    return;
}
// $stmt = $pdo->query("SELECT user_id FROM profile WHERE profile_id=".$_GET['profile_id']." AND user_id=".$_SESSION['user_id']);
//
// if ($stmt->rowCount() < 1 ) {
//     $_SESSION['error'] = "User not permitted to delete entry";
//     header("Location: index.php");
//     return;
// }

if ( isset($_POST['delete']) && isset($_POST['word_id']) ) {
    if ( $_SESSION['user_id'] == 14 ) {
        $_SESSION['error'] = "Guest cannot delete entries";
        header("Location: view.php");
        return;
    }
    $sql = "DELETE FROM doggo_dict WHERE word_id = :zip;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['word_id']));
    $_SESSION['success'] = 'Entry deleted';
    header('Location: view.php' );
    return;
}
$stmt = $pdo->prepare("SELECT dkey, dvalue, word_id FROM doggo_dict where word_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['word_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false ) {
    $_SESSION['error'] = 'Bad value for word_id';
    header( 'Location: view.php' );
    return;
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <title>Doggo Translate Admin - Delete Entry</title>
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
       if ( isset($_SESSION["name"]) ) {
           echo '<li class="active"><a href="view.php"> View Entries</a></li>';
           echo '<li><a href="add.php"> Add Entry</a></li>';
       }

        ?>
     </ul>
     <ul class="nav navbar-nav navbar-right">
       <?php
       if ( isset($_SESSION["name"]) && $_SESSION['user_id'] != 14 ) {
           echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Admin Logout</a></li>';
       }
       else if ( isset($_SESSION["name"]) && $_SESSION['user_id'] == 14) {
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

<h1 style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">Doggo Translate Admin - Deleting Entry</h1>
<hr>
<h3 class="text-warning">Are you sure you want to delete the following:</h3>
<!-- <p>English Term: <?= htmlentities($row['dkey']) ?></p>
<p>Doggo Term: <?= htmlentities($row['dvalue']) ?></p> -->

<form method="post" class="form-inline"><input type="hidden" name="word_id" value="<?= $row['word_id'] ?>">
    <label class="form-control-static">English Term:</label> <?= htmlentities($row['dkey']) ?><br>
    <label class="form-control-static">Doggo Term:&nbsp;</label> <?= htmlentities($row['dvalue']) ?><br>
    <input type="submit" class="form-control form-horizontal btn btn-warning" value="Delete" name="delete">
    <input type = "submit" class="form-control form-horizontal btn btn-default" name="cancel" value="Cancel">
</form>

</main>

</body>
</html>
