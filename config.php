<?php
// connect database ด้วย mysqli
$host = "localhost";
$username = "root";
$password = "";
$database = "online_shop";

$dns = "mysql:host=$host;dbname=$database";

//$conn = new mysqli($host, $username, $password, $database);

//if($conn -> connect_error){
//   die("Connect failed:" . $conn -> connect_error);
//} else{
//   echo "Conected succeessfully";
//}

    //connect database ด้วย PDO
    try {
        $conn = NEW PDO($dns, $username, $password,);
        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        echo "";

    } catch(PDOException $e){
        echo "NO" .$e->getMessage();

    }



?>