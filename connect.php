<?php
    require_once('db.php');

    function dbConnect($db) {
        try {
            $db = new PDO(
                "mysql:host=".DB_HOST.
                ";port=".DB_PORT.
                ";dbname=".DB_NAME,
                DB_USER,
                DB_PW
            );
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

        return $db;
    }

    /*
     *    if (!$dbconn = mysql_connect(DB_HOST, DB_USER, DB_PW)) {
     *        echo 'Could not connect to mysql on ' . DB_HOST . "\n";
     *        exit;
     *    }
     *
     *    //echo 'Connected to mysql on ' . DB_HOST . "\n";
     *
     *    if (!mysql_select_db(DB_NAME, $dbconn)) {
     *        echo 'Could not use database ' . DB_NAME . "\n";
     *        echo mysql_error() . "\n";
     *        exit;
     *    }
     */

    //echo 'Connected to database ' . DB_NAME . "\n";
?>
