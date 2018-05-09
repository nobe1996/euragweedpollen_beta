<?php
if (isset($_GET['tables'])){
	echo "Tables";
} else if (isset($_GET['upload'])){
	echo "Upload";
} else if (isset($_GET['manual'])){
	echo "User guide"; 
} else if (isset($_GET['forgotpass'])){
	echo "Forgot password";
} else if (isset($_GET['signup']) && !$_SESSION['login']){
	echo "Registration";
} else if (!$_SESSION['login']){
	echo "Login";
} else {
	echo "Home";
}
?>