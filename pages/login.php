<?php
$message = "";
if(isset($_POST['send'])){
	$jelszo = $_POST['password'];
	$username = $_POST['username'];
	$result = mysqli_query($dbconn,"SELECT id,felhasz,jelszo FROM users WHERE felhasz='".mysqli_real_escape_string($dbconn,$username)."'");
	if ($username != "" && $jelszo != "") {
		if (mysqli_num_rows($result) == 0){
			$message = "This user doesn't exist!";
		} else {
			$row = mysqli_fetch_assoc($result);		
			if ($jelszo != $row['jelszo']){
				$message = "Incorrect pasword!";
				$alert_pass = '<img src="./style/images/alert.png" />';
			} else {
				$_SESSION['login'] = true;
				$_SESSION['login_name'] = $row['felhasz'];
				$_SESSION['id'] = $row['id'];
				$result = mysqli_query($dbconn,"SELECT uid FROM admin WHERE uid='".mysqli_real_escape_string($dbconn,$row['id'])."'");
				if (mysqli_num_rows($result) == 1){
					$_SESSION['admin'] = true;
				}
				$_POST = array();
				header("Location: ./index.php");
			}
		}
	}
	$_POST = array();
}
?>
<div class="login">
	<?php if ($message != ""){ ?>
		<div class="error-message">
			<p><?php echo $message; ?></p>
		</div>
	<?php } ?>
	<form class="login-form" method="post" action="./index.php">
		<label>Username:</label>
		<input type="text" name="username" value="" placeholder="Please type your username..." required/>
		<label>Password:</label>
		<input type="password" name="password" value="" placeholder="Please type your password..." required/>
		<p>
			<a href="./index.php?signup">Registration</a>
			<a href="./index.php?forgotpass">Forgot password</a>
			<a href="./index.php?manual">User guide</a>
		</p>
		<input type="submit" name="send" value="Login"/>
	</form>
</div>