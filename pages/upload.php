<?php
$message_city = "";
$message_data = "";
if (!isset($_SESSION['login'])){
	$_SESSION['login'] = false;
}
if($_SESSION['login']){
	if(isset($_POST['send'])){
		if($_POST['date'] != "" && $_POST['city'] != "" && $_POST['value'] != ""){
			//$date = explode("-",$_POST['date']);
			//$day = date('z', strtotime($_POST['date'])) + 1;
			if(mysqli_query($dbconn,"INSERT INTO `changes` (`uid`,`date`,`city`,`value`) VALUES (".mysqli_real_escape_string($dbconn,$_SESSION['id']).", '".mysqli_real_escape_string($dbconn,$_POST['date'])."', '".mysqli_real_escape_string($dbconn,strtoupper($_POST['city']))."', ".mysqli_real_escape_string($dbconn,$_POST['value']).")")){
				$message_data = "Successful data upload!";
			} else {
				$message_data = "Data upload failed!";
			}
		} else {
			$message_data = "The fields can't be empty!";;
		}
	} else if(isset($_POST['citysend'])){
		if($_POST['city'] != ""){
			if (strlen($_POST['city']) == 6){
				if(mysqli_query($dbconn,"INSERT INTO `changes` (`uid`,`date`,`city`) VALUES (".mysqli_real_escape_string($dbconn,$_SESSION['id']).", '-', '".mysqli_real_escape_string($dbconn,$_POST['city'])."')")){
					$message_city = "Successful station upload";
				} else {
					$message_city = "Station upload failed!";
				}
			} else {
				$message_city = "The station format is not correct!";
			}
		} else {
			$message_city = "The station field can't be empty!";
		}
	}
?>
<div class="row">
    <div class="col-xs-3">
        <div class="form-group">
			<form method="post" action="">
				<label for="date">Date</label>
				<div class="input-group col-xs-12">
					<input name="date" type="text" id="my-date" class="form-control form-date" required>
				</div>
				<label for="city">Station</label>			
				<div class="input-group col-xs-12">
					<select class="form-control" name="city" required>
						<option value="">Choose...</option>
						<?php
							$result = mysqli_query($dbconn,"SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'kokanymu_pollen' AND TABLE_NAME = '2017';");
							mysqli_fetch_assoc($result);
							while($row = mysqli_fetch_assoc($result)){
								echo '<option value="'.$row['COLUMN_NAME'].'">'.$row['COLUMN_NAME'].'</option>';
							}
						?>
					</select>
				</div>
				<label for="value">Value</label>			
				<div class="input-group col-xs-12">
					<input name="value" type="number" class="form-control" >
				</div>
				<input name="send" type="submit" class="form-control" value="Save" required>
			</form>
			<?php echo ($message_data <> "") ? '<p class="alert-message">'.$message_data.'</p>' : '';?>
        </div>
		
	</div>
	<div class="col-xs-6">
        <div class="form-group">
			<form method="post" action="">
				<p>Required format:</p>
				<p>- First 2 letter of a country (Hungary - HU)</p>
				<p>- First 4 letter of a staion (Csongrád - CSON)</p>
				<label for="date">Station</label>
				<div class="input-group col-xs-12">
					<input name="city" type="text" class="form-control" placeholder="example.: Hungary Csongrád - HUCSON" required>
				</div>
				<input name="citysend" type="submit" class="form-control" value="Add station" required>
			</form>
			<?php echo ($message_city <> "") ? '<p class="alert-message">'.$message_city.'</p>' : '';?>
        </div>
	</div>
</div>
<?php }?>