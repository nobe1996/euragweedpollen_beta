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

if (isset($_SESSION['admin'])){
	if ($_SESSION['admin']){
		if (isset($_GET['accept'])){
			if(filter_var($_GET['accept'], FILTER_VALIDATE_INT)){
				$result = mysqli_query($dbconn,"SELECT * FROM `changes` WHERE id =".mysqli_real_escape_string($dbconn,$_GET['accept']));
				if (mysqli_num_rows($result) > 0){
					$row = mysqli_fetch_assoc($result);
					if ($row['date'] != "-"){
						$day = date("z", strtotime($row['date']))+1;
						mysqli_query($dbconn,"UPDATE `changes` SET pending=2 WHERE id=".mysqli_real_escape_string($dbconn,$_GET['accept']));
						mysqli_query($dbconn,"UPDATE `2017` SET ".mysqli_real_escape_string($dbconn,$row['city'])."='".mysqli_real_escape_string($dbconn,$row['value'])."' WHERE id=".mysqli_real_escape_string($dbconn,$day));
					} else if($row['date'] == "-"){
						mysqli_query($dbconn,"UPDATE `changes` SET pending=2 WHERE id=".mysqli_real_escape_string($dbconn,$_GET['accept']));
						mysqli_query($dbconn,"ALTER TABLE `2017` ADD `".mysqli_real_escape_string($dbconn,$row['city'])."` varchar(10)");
					}
				}
			}
		} else if(isset($_GET['reject'])){
			if(filter_var($_GET['reject'], FILTER_VALIDATE_INT)){
				mysqli_query($dbconn,"UPDATE `changes` SET pending=1 WHERE id=".$_GET['reject']);
			}
		}
		?>
		<div id="header">
			<div class="header-menu">
				<ul class="admin">
					<li><a href="index.php?city">Stations</a></li>
					<li><a href="index.php?data">Data</a></li>
					<li><a href="index.php?logout"><img src="./style/images/logout.png"/></a></li>
				</ul>
			</div>
		</div>
		<?php if(isset($_GET['city'])){?>
			<div class="change-list">
				<ul>
					<li>Station</li>
					<li>Status</li>
				</ul>
				<?php
				$result = mysqli_query($dbconn,"SELECT * FROM `changes` WHERE date = '-'"); 
				if (mysqli_num_rows($result) > 0){		
					while($row = mysqli_fetch_assoc($result)){
						echo '<ul>
								<li>'.$row['city'].'</li>
								<li>'.get_pending($row['pending']).'<a href="index.php?city&accept='.$row['id'].'"><img src="style/images/ok.png" /></a><a href="index.php?city&reject='.$row['id'].'"><img src="style/images/notok.png" /></a></li>
							</ul>';
					}
				}
				?>
			</div>
		<?php } else if(isset($_GET['data'])){?>
			<div class="change-list">
				<ul>
					<li>Date</li>
					<li>Station</li>
					<li>Value</li>
					<li>Status</li>
				</ul>
				<?php
				$result = mysqli_query($dbconn,"SELECT * FROM `changes` WHERE date != '-'"); 
				if (mysqli_num_rows($result) > 0){		
					while($row = mysqli_fetch_assoc($result)){
						echo '<ul>
								<li>'.$row['date'].'</li>
								<li>'.$row['city'].'</li>
								<li>'.$row['value'].'</li>
								<li>'.get_pending($row['pending']).'<a href="index.php?data&accept='.$row['id'].'"><img src="style/images/ok.png" /></a><a href="index.php?data&reject='.$row['id'].'"><img src="style/images/notok.png" /></a></li>
							</ul>';
					}
				}
				?>
			</div>
		<?php }	
	}
}
?>