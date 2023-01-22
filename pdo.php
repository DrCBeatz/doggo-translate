<?php

    //Get Heroku ClearDB connection information
    $cleardb_url      = parse_url(getenv("CLEARDB_GREEN_URL"));
    $cleardb_server   = $cleardb_url["host"];
    $cleardb_username = $cleardb_url["user"];
    $cleardb_password = $cleardb_url["pass"];
    $cleardb_db       = substr($cleardb_url["path"],1);

    try {
        $pdo = new PDO("mysql:host=".$cleardb_server."; dbname=".$cleardb_db, $cleardb_username, $cleardb_password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $pdo = null;
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

?>