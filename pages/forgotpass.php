<?php
$message = "";
if(isset($_POST['send'])){
	$email = htmlspecialchars($_POST['email']);
	if (!empty($email)) {
		$result = mysqli_query($dbconn,"SELECT * FROM users WHERE email ='".mysqli_real_escape_string($dbconn,$email)."'");
		if (mysqli_num_rows($result) == 0){
			$message = "This email doesn't exist!";
		} else {
			$row = mysqli_fetch_assoc($result);
			$mess = "Dear  ".$row['veznev']." ".$row['kersznev']."!\n\nYour password: ".$row['jelszo'];
			mail($row['email'],"Forgot password!" , $mess);
		}
	} else {
		$message = "The e-mail field can't be empty!";
	}
	$_POST = array();
}
?>
<div class="login">
	<?php if ($message != ""){?>
		<div class="error-message">
			<p><?php echo $message;?></p>
		</div>
	<?php }?>
	<form class="login-form" method="post" action="./index.php?forgotpass">
		<label>E-mail:</label>
		<input type="email" name="email" value="" placeholder="Please type your e-mail..." required/>
		<input type="submit" name="send" value="Send"/>
	</form>
</div>