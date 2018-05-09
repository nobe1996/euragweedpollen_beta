<?php
session_start();
include_once('dbconnect.php');
if (isset($_GET['logout'])){
	unset($_SESSION['login']);
	unset($_SESSION['admin']);
	unset($_SESSION['login-name']);
	unset($_SESSION['id']);
}
if (!isset($_SESSION['login'])){
	$_SESSION['login'] = false;
	$_SESSION['admin'] = false;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<link rel='stylesheet' id='style-css'  href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.0.0/css/bootstrap-datetimepicker.min.css' type='text/css' media='all' />
	<link rel='stylesheet' id='style-css'  href='http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css' type='text/css' media='all' />	
	<link rel='stylesheet' id='style-css'  href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css' type='text/css' media='all' />
	<link rel='stylesheet' id='style-css'  href='//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css' type='text/css' media='all' />
	<link rel='stylesheet' id='style-css'  href='./style/style.css' type='text/css' media='all' />
	<script type="text/javascript" src="//code.jquery.com/jquery-2.1.0.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
	<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.0.0/js/bootstrap-datetimepicker.min.js"></script>
	<script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.4/Chart.min.js"></script>		<!--norbi-->
	<title><?php include_once('./pages/titles.php');?></title>
	<script type='text/javascript'>
		$(window).load(function(){
		$( '#my-date' ).datetimepicker( { format: 'YYYY-MM-DD' } );
		});W
	</script>
</head>
<body>
	<div id="container">
		<?php if($_SESSION['login'] && $_SESSION['admin'] == false){ ?>
		<div id="header">
			<div class="header-menu clearfix">
				<ul>
					<li <?if(empty($_GET)){echo ' class="current-page"';}?>><a href="index.php">My profile</a></li>
					<li <?if(isset($_GET['tables'])){echo ' class="current-page"';}?>><a href="index.php?tables">Tables</a></li>
					<li <?if(isset($_GET['upload'])){echo ' class="current-page"';}?>><a href="index.php?upload">Data recording</a></li>
					<li><a href="index.php?logout"><img src="./style/images/logout.png"/></a></li>
				</ul>
			</div>
		</div>
		<?php }?>
		<div <?php echo ($_SESSION['login'])? 'id="content"': ""; ?> class="clearfix">
			<?php include_once('./pages/pages.php'); ?>
		</div>
		<?php if($_SESSION['login']){ ?>
		<div id="footer" class="clearfix">
		</div>
		<?php } ?>
	</div>
</body>
</html>