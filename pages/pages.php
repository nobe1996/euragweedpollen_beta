<?php
if (isset($_GET['tables'])){
	include_once("tables.php");
} else if (isset($_GET['upload'])){
	include_once("upload.php");
} else if (isset($_GET['manual'])){
	include_once("manual.html");
} else if (isset($_GET['forgotpass'])){
	include_once("forgotpass.php");
} else if (isset($_GET['signup']) && !$_SESSION['login']){
	include_once("signup.php");
} else if (!$_SESSION['login']){
	include_once("login.php");
} else if ($_SESSION['admin']){
	include_once("admin.php");
} else {
	include_once("home.php");
}
?>