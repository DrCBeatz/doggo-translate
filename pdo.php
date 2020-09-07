
<?php

// echo "<pre>\n";

// stores connection to database in object called $PDO
$pdo = new PDO('mysql:host=localhost;port=8889;dbname=misc','fred','zap');

// Tuns on error messages in PDO

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


?>
