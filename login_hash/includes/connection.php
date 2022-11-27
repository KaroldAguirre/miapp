<?php

require_once("constants.php");


try{
    $connection = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
}
catch(Exception $e){
    die($e->getMessage());
}

?>