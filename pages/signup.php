<?php
$message = "";
if (isset($_POST['signup'])){
	$result = mysqli_query($dbconn,"SELECT felhasz FROM users WHERE felhasz='".htmlspecialchars($_POST['felhasz'])."'");
	if (htmlspecialchars($_POST["felhasz"]) == "" ||
			htmlspecialchars($_POST["veznev"]) == "" ||
			htmlspecialchars($_POST["kersznev"]) == "" ||
			htmlspecialchars($_POST["pass"]) == "" ||
			htmlspecialchars($_POST["passagain"]) == "" ||
			htmlspecialchars($_POST["email"]) == ""){
		$message = "The fields with * can't be empty!";
	}else if (mysqli_num_rows($result) > 0){
		$message = "This user has already exist!";
	} else if(!filter_var(htmlspecialchars($_POST["email"]), FILTER_VALIDATE_EMAIL)){
		$message = "Please write a real e-mail address!";
	} else if(strlen(htmlspecialchars($_POST['pass'])) < 8){
		$message = "The password need to be at least 8 character!";
	} else if((htmlspecialchars($_POST['pass']) != htmlspecialchars($_POST['passagain']))){
		$message = "The passwords do not match!";
	} else {
		$values = "'".mysqli_real_escape_string($dbconn,$_POST["felhasz"])."','".mysqli_real_escape_string($dbconn,$_POST["pass"])."','".mysqli_real_escape_string($dbconn,$_POST["veznev"])."','".mysqli_real_escape_string($dbconn,$_POST["kersznev"])."','".mysqli_real_escape_string($dbconn,$_POST["email"])."'";
		mysqli_query($dbconn,"INSERT INTO `users` (`felhasz`, `jelszo`, `veznev`, `kersznev`, `email`) VALUES (".$values.");");
		$_SESSION['login'] = true;
		$_SESSION['login_name'] = htmlspecialchars($_POST['felhasz']);
		$result = mysqli_fetch_assoc(mysqli_query($dbconn,"SELECT id FROM users WHERE felhasz='".mysqli_real_escape_string($dbconn,$_POST["felhasz"])."'"));
		$_SESSION['id'] = $result['id'];
		header("Location: ./index.php");
	}
}
$_POST = array();
?>
<div class="login">
	<?php if ($message != ""){?>
		<div class="error-message">
			<p><?php echo $message;?></p>
		</div>
	<?php }?>
	<form class="login-form" method="post" action="./index.php?signup">
		<label for="felhasz"> Username:*</label>
		<input type="text" name="felhasz" value="" required/>
		<label for="email"> Email:* </label>
		<input type="email" name="email" value="" required/>
		<label for="veznev"> Surname:* </label>
		<input type="text" name="veznev" value="" required/>
		<label for="kersznev"> First Name:* </label>
		<input type="text" name="kersznev" value="" required/>
		<label for="pass"> Password:* (min 8 character)</label>
		<input type="password" name="pass" value="" required/>
		<label for="passagain"> Password again:*</label>
		<input type="password" name="passagain" value="" required/>
		<a href="http://kokany-murc.hu/pollen/index.php">Back</a>
		<input type="submit" name="signup" value="Register" />
	</form>
</div>