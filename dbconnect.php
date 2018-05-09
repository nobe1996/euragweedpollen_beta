<?php
$dbconn = mysqli_connect("localhost", "root", "");
mysqli_select_db($dbconn,"kokanymu_pollen") or die("Hibás csatlakozás az adatbázishoz!"); 
mysqli_query($dbconn,"SET  NAMES 'utf8'");
?>