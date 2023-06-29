<?php
ob_start();
session_start();
require_once 'pdo.php';
require_once "util.php";

$doggo_dict = array("hello"=>"henlo", "friend"=>"fren", "dog"=>"doggo",
                "bark"=>"bork");
$new_message = "";



$statement = $pdo->query("SELECT dkey, dvalue FROM doggo_dict;");
$row = $statement->fetchall(PDO::FETCH_ASSOC);

$dict = array();

if ( isset($_POST['translate']) && $_POST['translate'] == '2') {

    foreach( $row as $item) {
         $dict += [$item['dvalue']=>$item['dkey'] ];
     }
}

else {
    foreach( $row as $item) {
         $dict += [$item['dkey']=>$item['dvalue'] ];
     }
}

    if ( isset($_POST['message']) )
    {

        $message = $_POST['message'];

        $new_message = strtolower($message);

        foreach ($dict as $key=>$value) {

            if ( strpos($new_message, $key) !== false) {

                $new_message = str_replace($key, $value, $new_message);
                unset($_POST['message']);
            }
        }

    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Doggo Translate - Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php require_once "head.php"; ?>
<style>
textarea
{
  border:1px solid #999999;
  width:100%;
  margin:5px 0;
  padding:3px;
}

.boxsizingBorder {
    -webkit-box-sizing: border-box;
       -moz-box-sizing: border-box;
            box-sizing: border-box;
}
</style>
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
    <a class="navbar-brand" href="#">Doggo Translate</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li class="active"><a href="#">Home</a></li>
      <li><a href="about.php">About</a></li>
      <?php
      if ( isset($_SESSION["name"]) ) {
          echo '<li><a href="view.php"> View Entries</a></li>';
          echo '<li><a href="add.php"> Add Entry</a></li>';
      }
       ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <!-- <li><a href="login.php">Admin Login</a></li> -->
      <!-- <li><a href="#"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li> -->
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
<?php

if ( isset($_SESSION["name"]) ) {
    echo('<h1 style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.2));">Doggo Translate Admin - Home</h1>');
}
else {
    echo('<h1 style="filter: drop-shadow(3px 3px 3px rgba(0,0,0,0.2));">Doggo Translate - Home</h1>');
}


flashMessages();

?>

<hr>
<div class="form-group">
<form class = "form-inline" method="POST" action="index.php">

<label for="translate" class="form-control-static">Language:</label>
<select class="select form-control" name="translate" id="translate">
    <option value ="1" selected>English to Doggo</option>
    <option value ="2">Doggo to English</option>
</select>
    <?php
    // if ( isset($_POST['translate']) && $_POST['translate'] == '2' ) {
    //     echo ('<select class="select" name="translate" id="translate"><br><option value ="1">English to Doggo</option><option value ="2" selected>Doggo to English</option></select>');
    // }
    // else {
    //     echo ('<select class="form-control" name="translate" id="translate"><br><option value ="1">English to Doggo</option><option value ="2">Doggo to English</option></select>');
    // }
    ?>

    <p></p>
    <label for="message" class="form-control-static">Your message: </label>
    <textarea class="form-control" name="message" id="message" rows="4" style="width:100%" placeholder="Enter message to be translated"></textarea>
<p></p>
    <input type="submit" class="btn btn-primary form-control" name="doggo_translate" onclick="return doValidate();" id="doggo_translate" value="Translate">

</form>
</div>
<p></p>
<div class="form-group">
</div>




<script>
function doValidate() {
    // console.log('Validating...');
    try {
        msg = document.getElementById('message').value;

        if (msg == null || msg == "" ) {
            alert("Please enter message to translate");
            return false;
        }
        return true;
        } catch (e) {
            return false;
    }
    return false;
}

function doggo_translate() {

        doValidate();
          var doggo_dict = {};
          var message = document.getElementById("message").value;
          var newmessage = message;

          fetch('getjson.php')
            .then(
              function(response) {
                if (response.status !== 200) {
                  console.log('Looks like there was a problem. Status Code: ' +
                    response.status);
                  return false;
                }
                response.json().then(function(data) {
                  // console.log(data);
                  for (var i = 0; i < data.length; i++) {
                      var tval = document.getElementById("translate").value;
                      if (tval == 1 ) {
                      doggo_dict[data[i].dkey] = data[i].dvalue;
                      }
                      else {
                          doggo_dict[data[i].dvalue] = data[i].dkey;
                      }
                  }
                  for (var key in doggo_dict) {
                      var value = doggo_dict[key];

                       if ( message.includes(key) == true ) {
                           message = message.replaceAll(key, value);
                       }
                  }
                  document.getElementById("message").value = message;
                  return true;
                });
              }
            )
            .catch(function(err) {
              console.log('Fetch Error :-S', err);
              return false;
            });
    }

</script>
<?php

if ( $new_message != "" ) {
    // if ( isset ($_POST['message'] ) !== false ) {
    // echo ("<p>Old message: ". $message );
    // }
    echo ("<p><strong>Translated message: </strong>". $new_message );

}


// if ( isset($_SESSION["name"]) ) {
//     echo('<p><a href="view.php">View Entries</a></p>');
//     echo('<p><a href="logout.php">Logout</a></p>');
// }
// else {
//     echo('<p><a href="login.php">Please log in</a></p>');
// }

?>

<img src="images/beach1c.jpg" alt="Dogs running on tropical beach" class="img-rounded img-responsive" style="filter: drop-shadow(5px 5px 5px rgba(0,0,0,0.3));" >



</main>









</body>
 </html>
