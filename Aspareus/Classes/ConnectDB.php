<?php
    $host = "localhost";
    $dbname = "aspareus";
    $user = "root";
    $pass = "";

    try
    {
        $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (PDOException $ex)
    {
        echo "Error: " . $ex;
    }
?>
