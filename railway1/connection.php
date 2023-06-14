<?php
    $servername="localhost";
    $username="root";
    $password="";
    $dbname="railway";

    $conn = mysqli_connect($servername,$username,$password,$dbname);

    $mysqli = new mysqli("localhost","root","","railway");

    if($conn)
    {
        echo "";
    }
    else{
        echo"Connection failed";
    }
?>