<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>
<?php /*
include_once('dbconnect.php');
$data = "";
$asd = array(array());
$file = fopen('fixedData.csv','r');
$asd =  fgets($file);
$seged = explode(",",$asd);
for ($i = 0; $i < count($seged)-1; $i++){
	$data .= "`".$seged[$i]."`,";
}
$data .= "`".preg_replace("/\r|\n/","",$seged[count($seged)-1])."`";

fclose($file);
$file = fopen('asd.txt','r');
//for ($i = 1997; $i < 2011; $i++){
	//$line = fgets($file);
	for ($j = 0; $j < 366;$j++){
		$values = "";
		$seged = array();
		$line = fgets($file);
		$seged = explode(",",$line);
		for ($k = 1; $k < count($seged)-1; $k++){
			$values = $values."'".$seged[$k]."',";
		}
		$values = $values."'".preg_replace("/\r|\n/","",$seged[count($seged)-1])."'";
		//echo "INSERT INTO `2001` (".$data.") VALUES (".$values.");";
		mysqli_query($dbconn,"INSERT INTO `2008` (".$data.") VALUES(".$values.")");
	}
//}
fclose($file);
/**/
if (!isset($_SESSION['login'])){
	$_SESSION['login'] = false;
}
if($_SESSION['login']){
?>
<h1 class="title-style1">Tables</h1>
<div class="tables">
	<div class="tables-years clearfix">
		<form class="tables-years-form col-xs-3" action="" method="post">
			<label>Station:</label>
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
			<label>Year:</label>
			<select class="form-control" name="year">
				<?php
					echo '<option value="">Choose...</option>';
					for ($i = 1995; $i < 2011; $i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
					echo '<option value="2017">2017</option>';
				?>
			</select>
			<label>Fixed year:</label>
			<select class="form-control" name="correct-year">
				<?php
					echo '<option value="">Choose...</option>';
					for ($i = 1995; $i < 2011; $i++){
						echo '<option value="'.$i.'">'.$i.'</option>';
					}
				?>
			</select>
			<input type="submit" name="send" value="Show it" />
		</form>
	<?php
	if (isset($_POST['send'])){	
		if (($_POST['correct-year'] != "" || $_POST['year'] != "") && $_POST['city'] != ""){			
			if ($_POST['correct-year'] != ""){
				$year = $_POST['correct-year'];
			} else {
				$year = $_POST['year'];
			}?>		
			<div class="tables-selected">
				<p>Choosed station: <?php echo $_POST['city'];?></p>
				<p>Choosed year: <?php echo $year ;?></</p>
			</div>
			<?php
			echo '</div>';
			$nap = 1;									
			$stack = array();								
	?>
			
		<div class="chart">
		<canvas id="pollenChart" width="900" height="400"></canvas>
		</div>
	<?php
			if ($_POST['correct-year'] != ""){
				$basesql = mysqli_query($dbconn,"SELECT ".$_POST['city']." FROM `".$year."`");
				$result = mysqli_query($dbconn,"SELECT ".$_POST['city']." FROM `".$year."f`");
				
				for ($i = 1; $i < 53; $i++){
					echo '<ul>';
					echo '<li>'.$i.". hét</li>";
					for ($j = 0; $j < 7; $j++){
						$base = mysqli_fetch_array($basesql);
						$row = mysqli_fetch_array($result);
						
						if ($row[0] != ""){
							if($row[0] == $base[0]){
								echo '<li>'.$row[0].'</li>';
							}else{
								echo '<li class="changed">'.$row[0]."</li>";
								//echo '<li class="changed"">-</li>';
							}
							$nap++;								
							if($nap >= 197 && $nap <= 289){		
								if($row[0] == "-9"){			
									array_push($stack, 0);		
								}else{							
									array_push($stack, $row[0]);
								}								
							}									
						} else {
							echo '<li>-</li>';
						}
					}
					echo '</ul>';
				}
				echo '<ul>';
				echo '<li>53. hét</li>';
				for ($j = 0; $j < 2; $j++){
					$row = mysqli_fetch_array($result);
					if ($row[0] != ""){
						echo '<li>'.$row[0]."</li>";
					} else {
						echo '<li>-</li>';
					}
				}
				echo '</ul>';
			} else {
				$result = mysqli_query($dbconn,"SELECT ".$_POST['city']." FROM `".$year."`");
				for ($i = 1; $i < 53; $i++){
					echo '<ul>';
					echo '<li>'.$i.". hét</li>";
					for ($j = 0; $j < 7; $j++){
						$row = mysqli_fetch_array($result);
						if ($row[0] != ""){
							echo '<li>'.$row[0]."</li>";
							$nap++;								
							if($nap >= 197 && $nap <= 289){		
								if($row[0] == "-9"){			
									array_push($stack, 0);		
								}else{							
									array_push($stack, $row[0]);
								}								
							}									
						} else {
							echo '<li>-</li>';
						}
					}
					echo '</ul>';
				}
				echo '<ul>';
				echo '<li>53. hét</li>';
				for ($j = 0; $j < 2; $j++){
					$row = mysqli_fetch_array($result);
					if ($row[0] != ""){
						echo '<li>'.$row[0]."</li>";
					} else {
						echo '<li>-</li>';
					}
				}
				echo '</ul>';
			}
			echo '</div>';
			
	?>
		<script>
		var ctx = document.getElementById("pollenChart");
		document.getElementById("pollenChart").style.backgroundColor = 'rgba(158, 167, 184, 0.3)';
		Chart.defaults.global.defaultFontSize = 11;
		Chart.defaults.global.defaultFontColor = "#F2EF68";
		var myChart = new Chart(ctx, {
			type: 'line',
			maintainAspectRatio: true,
			data: {
				labels: [
			<?php
			for($i=0;$i<sizeof($stack);$i++){
				//echo "'".$i."',";
				echo " ,";
			}
			?>
				],
				datasets: [{
					label: 'Pollenszint változása a választott év pollenszezonjában.',
					pointBackgroundColor: "#ff0000",
					data: [
						<?php											
						for($i=0;$i<sizeof($stack);$i++){				
							echo $stack[$i] . ",";
						}
						?>			
						],
					backgroundColor: ['rgba(255, 255, 255, 0.6)'],
					borderColor: ['rgba(0,0,0,1)'],
					borderWidth: 2
				}]
			},
			
			options: {
				fullWidth: true,
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
		</script>
<?php												
			
			$_POST = array();
		}  else {
			echo '</div>';
		}
	} else {
		echo '</div>';
	}
	?>
</div>
<?php } ?>