
<?php

// echo "<pre>\n";

// stores connection to database in object called $PDO
$pdo = new PDO('mysql:host=us-cdbr-east-06.cleardb.net;port=8889;dbname=heroku_1c173b5d5bc86a2','b89a80ef248678','2a576ba3');
// mysql://b89a80ef248678:2a576ba3@us-cdbr-east-06.cleardb.net/heroku_1c173b5d5bc86a2?reconnect=true
// Tuns on error messages in PDO

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
