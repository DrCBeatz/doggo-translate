<?php
    ob_start();
    require_once 'pdo.php';
    require_once "util.php";
    session_start();
    unset($_SESSION['name']);
    unset($_SESSION['user_id']);

    if ( isset($_POST['cancel'] ) ) {
        header("Location: index.php");
        return;
    }

    $salt = 'XyZzy12*_';

if (isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {

        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }

    $check = hash('md5', $salt.$_POST['pass']);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users WHERE email = :em AND password = :pw');

    $stmt->execute(array(':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row !== false) {
        $_SESSION['name'] = $row['name'];
        $_SESSION['user_id'] = $row['user_id'];

        // $_SESSION['success'] = "Admin login successful";

        header("Location: view.php");
        return;
    } else {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        return;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Doggo Translate Admin - Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once "head.php"; ?>
</head>
<body style="font-family: sans-serif;">

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
      <!-- <li class="active"><a href="login.php">Login</a></li> -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
      <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
      <?php
      if ( isset($_SESSION["name"]) && $_SESSION['user_id'] != 4) {
          echo '<li class="active"><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Admin Logout</a></li>';
      }
      else if ( isset($_SESSION["name"]) && $_SESSION['user_id'] == 4) {
          echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Guest Logout</a></li>';
      }
      else {
          echo '<li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Admin Login</a></li>';
      }
      ?>
    </ul>
    </div>
    </div>
    </nav>

<main>

<!-- <div class="container"> -->
<h1 style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.3));">Doggo Translate Admin - Login</h1>

<hr>

<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.htmlentities($_SESSION["error"])."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<div class="container">
<!-- <div class="form-horizontal"> -->
<div class="form-group">
<form class="form-inline" method="POST" action="login.php">
<label for="email" class="control-label " >Username: </label>
<!-- <div class="col-sm-10"> -->
<input type="text" name="email" id="email" class="form-control form-horizontal" placeholder="Enter email address" size="60">
<p></p>
<!-- </div> -->
<label for="id_1723" class="control-label ">Password: </label>
<!-- <div class="col-sm-10"> -->
<input type="password" name="pass" id="id_1723" class="form-control form-horizontal" placeholder="Enter password" size="60">
<p></p>
<!-- </div> -->
<!-- <div class="form-group">
<div class="col-sm-offset-2 col-sm-10"> -->
<p></p>
<input class ="form-control form-horizontal btn btn-primary" type="submit" onclick="return doValidate();" value="Log In">
<input class ="form-control form-horizontal btn btn-default" type="submit" name="cancel" value="Cancel">
<!-- </div>
</div> -->
</form>
</div>
<!-- </div> -->
</div>
<script>
function doValidate() {
    console.log('Validating...');
    try {
        addr = document.getElementById('email').value;
        pw = document.getElementById('id_1723').value;
        console.log("Validating addr="+addr+" pw="+pw);
        if (addr == null || addr == "" || pw == null || pw == "") {
            alert("Both fields must be filled out");
            return false;
        }
        if ( addr.indexOf('@') == -1 ) {
            alert("Invalid email address");
            return false;
        }
        return true;
        } catch (e) {
            return false;
    }
    return false;
}
</script>

<br>

<img src="images/house.jpg" alt="Dogs sitting in beach house" class="img-rounded img-responsive" style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3))">

</main>

</body>
