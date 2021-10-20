<?php
try {
    $con = new PDO("mysql:host=localhost;dbname=tatvasoft", "root","");
} catch(PDOException $e) {
    echo $e->getMessage();
}

?>