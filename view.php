<?php
ob_start();
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['user_id']) )
{
    die('ACCESS DENIED');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Doggo Translate Admin - View Entries</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once "head.php" ?>

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
<h1 style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));">Doggo Translate Admin - View Entries</h1>
<hr>
<p>
    <?php
    if ( isset($_SESSION['error']) ) {
        echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
        unset($_SESSION['error']);
    }
    if ( isset($_SESSION['success'])) {
        echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
        unset($_SESSION['success']);
    }
?>



<?php

    // if ( isset($_SESSION["name"]) ) {
    //     echo('<p><a href="logout.php">Logout</a></p>');
    // }
    // else {
    //     echo('<p><a href="login.php">Please log in</a></p>');
    // }


    echo('<div class="table-responsive">');
    echo('<table class="table table-striped table-hover table-bordered">'."\n");
    $stmt = $pdo->query("SELECT word_id, dkey, dvalue FROM doggo_dict;");

        if ($stmt->rowCount() < 1) {
            echo('<p>No entries found</p>');
        } else {
            echo('<thead><tr>');
            echo('<th>English term</th>');
            echo('<th>Doggo term</th>');
            // if ( isset($_SESSION['name'])) {
            echo('<th>Action</th>');
            echo('</tr></thead>');
            // echo('<tbody">');
            // }
            while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
                echo "<tr><td>";
                echo(htmlentities($row['dkey']));
                echo("</td><td>");
                echo(htmlentities($row['dvalue']));
                echo("</td><td>");
                // if ( isset($_SESSION['name'])) {
                echo('<a href="edit.php?word_id='. $row['word_id'].'">Edit</a> | ' );
                echo('<a href="delete.php?word_id='. $row['word_id'].'">Delete</a>');
                // }
                // echo("\n</form>\n");
                echo("</td></tr>\n");
             }
             // echo('</tbody');
             echo('</table>');
             echo('</div>');

         }

         // if ( isset($_SESSION['name'] ))
         // {
         //     echo('<p><a href="add.php">Add New Entry</a></p>');
         // }


     ?>

     <!-- <p>
     <a href="index.php">Home</a>
     </p>

     <p>
     <a href="logout.php">Logout</a>
     </p> -->
</main>
</body>
