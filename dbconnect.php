<?php
$dbconn = mysqli_connect("localhost", "root", "");
mysqli_select_db($dbconn,"kokanymu_pollen") or die("Hib�s csatlakoz�s az adatb�zishoz!"); 
mysqli_query($dbconn,"SET  NAMES 'utf8'");
?>