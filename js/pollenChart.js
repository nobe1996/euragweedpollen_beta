var ctx = document.getElementById("pollenChart");
		document.getElementById("pollenChart").style.backgroundColor = 'rgba(158, 167, 184, 0.3)';
		Chart.defaults.global.defaultFontSize = 11;
		Chart.defaults.global.defaultFontColor = "#F2EF68";
		var myChart = new Chart(ctx, {
			type: 'line',
			maintainAspectRatio: true,
			data: {
				labels: [
			<?
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
						<?											
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