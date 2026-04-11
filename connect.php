<?php

    $host = "localhost";
    $db_user = "root";
    $db_password = "";
    $db_name = "osadnicy";

    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
		if($polaczenie->connect_errno!=0) {
            die("Bład połaczenie: ". $polaczenie->connect_errno);	
        }
        $polaczenie->set_charset("utf8");
?>
