<?php
function get_pending($pending){
	switch ($pending) {
		case 1:
			return '<font color="red">Elutasítva</font>';
			break;
		case 2:
			return '<font color="green">Elfogadva</font>';
			break;
		default;
			return 'Elfogadásra vár';
			break;
	}	
}

if (!isset($_SESSION['login'])){
	$_SESSION['login'] = false;
}
if($_SESSION['login']){
	$message = "";
	if (isset($_POST['edit'])){
		if (htmlspecialchars($_POST["felhasz"]) == "" ||
				htmlspecialchars($_POST["veznev"]) == "" ||
				htmlspecialchars($_POST["kersznev"]) == "" ||
				htmlspecialchars($_POST["pass"]) == "" ||
				htmlspecialchars($_POST["passagain"]) == "" ||
				htmlspecialchars($_POST["email"]) == ""){
			$message = "A *-al jelölt mezők kitöltése kötelező!";
		} else if(!filter_var(htmlspecialchars($_POST["email"]), FILTER_VALIDATE_EMAIL)){
			$message = "Kérlek adj meg valós e-mail címet!";
		} else if(strlen(htmlspecialchars($_POST['pass'])) < 8){
			$message = "A jelszónak min 8 karakternek kell lennie!";
		} else if((htmlspecialchars($_POST['pass']) != htmlspecialchars($_POST['passagain']))){
			$message = "A jelszavaknak meg kell egyezniük!";
		} else {
			$values = "felhasz ='".mysqli_real_escape_string($dbconn,$_POST["felhasz"])."', jelszo ='".mysqli_real_escape_string($dbconn,$_POST["pass"])."', veznev ='".mysqli_real_escape_string($dbconn,$_POST["veznev"])."', kersznev ='".mysqli_real_escape_string($dbconn,$_POST["kersznev"])."', email ='".mysqli_real_escape_string($dbconn,$_POST["email"])."'";
			if(mysqli_query($dbconn,"UPDATE `users` SET ".$values." WHERE id='".$_SESSION['id']."'")){
				$_SESSION['login_name'] = htmlspecialchars($_POST['felhasz']);
				$message = "Sikeres módosítás!";
			} else {
				$message = "Sikertelen módosítás!";
			}
		}
	}
	$_POST = array();
	$result = mysqli_query($dbconn,"SELECT felhasz,veznev,kersznev,email FROM `users` WHERE id=".mysqli_real_escape_string($dbconn,$_SESSION['id'])); 
	$row = mysqli_fetch_assoc($result);
	?>
	<h1 class="title-style1">Profile</h1>
	<div class="profile">
		<ul class="profile-labels">
			<li>Username: </li>
			<li>Surname:</li>
			<li>First Name:</li>
			<li>Email:</li>
		</ul>
		<ul class="profile-values clearfix">
			<li><?php echo $row['felhasz'];?></li>
			<li><?php echo $row['veznev'];?></li>
			<li><?php echo $row['kersznev'];?></li>
			<li><?php echo $row['email'];?></li>
		</ul>
	</div>
	<h1 class="title-style1">Change profile</h1>
	<div class="edit-profile">
		<form class="edit-form" method="post" action="./index.php">
			<label for="felhasz"> Username:*</label>
			<input type="text" name="felhasz" value="<?php echo $row['felhasz'];?>" required/>
			<label for="email"> Email:* </label>
			<input type="text" name="email" value="<?php echo $row['email'];?>" required/>
			<label for="veznev"> Surname:* </label>
			<input type="text" name="veznev" value="<?php echo $row['veznev'];?>" required/>
			<label for="kersznev"> First Name:* </label>
			<input type="text" name="kersznev" value="<?php echo $row['kersznev'];?>" required/>
			<label for="pass"> Password:* (min 8 character)</label>
			<input type="password" name="pass" value="" required/>
			<label for="passagain"> Password again:*</label>
			<input type="password" name="passagain" value="" required/>
			<input type="submit" name="edit" value="Change" />
		</form>
		<?php if ($message != ""){?>
			<div class="error-message">
				<p><?php echo $message;?></p>
			</div>
		<?php }?>
	</div>
	<h1 class="title-style1">Requested changes</h1>
	<div class="change-list">
		<ul>
			<li>Date</li>
			<li>Station</li>
			<li>Value</li>
			<li>Status</li>
		</ul>
	<?php
		$result = mysqli_query($dbconn,"SELECT * FROM `changes` WHERE uid=".$_SESSION['id']); 
		if (mysqli_num_rows($result) > 0){		
			while($row = mysqli_fetch_assoc($result)){
				echo "<ul>
						<li>".$row['date']."</li>
						<li>".$row['city']."</li>
						<li>".$row['value']."</li>
						<li>".get_pending($row['pending'])."</li>
					</ul>";
			}
		}
	?>
	</div>
<?php }?>