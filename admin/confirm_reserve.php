<!DOCTYPE html> 
<?php
	require_once 'validate.php';
	require 'name.php';
	require_once 'connect.php'; // Ensure database connection
?>
<html lang="en">
<head>
	<title>Hotel Online Reservation</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
	<nav style="background-color:rgba(0, 0, 0, 0.1);" class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand">Hotel Online Reservation</a>
			</div>
			<ul class="nav navbar-nav pull-right">
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" role="button">
						<i class="glyphicon glyphicon-user"></i> <?php echo $name;?>
					</a>
					<ul class="dropdown-menu">
						<li><a href="logout.php"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</nav>

	<div class="container-fluid">	
		<ul class="nav nav-pills">
			<li><a href="home.php">Home</a></li>
			<li><a href="account.php">Accounts</a></li>
			<li class="active"><a href="reserve.php">Reservation</a></li>
			<li><a href="room.php">Room</a></li>			
		</ul>	
	</div>
	<br />

	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="alert alert-info">Fill up form</div>
				<?php
					$transaction_id = $_REQUEST['transaction_id'];
					$query = $conn->query("SELECT * FROM `transaction` 
						NATURAL JOIN `guest` 
						NATURAL JOIN `room` 
						WHERE `transaction_id` = '$transaction_id'") or die(mysqli_error($conn));
					$fetch = $query->fetch_array();
				?>
				<br />
				<form method="POST" action="save_form.php">
					<input type="hidden" name="transaction_id" value="<?php echo $fetch['transaction_id']; ?>">
					
					<div class="form-inline" style="float:left;">
						<label>Firstname</label><br />
						<input type="text" value="<?php echo $fetch['firstname']; ?>" class="form-control" size="40" disabled />
					</div>
					<div class="form-inline" style="float:left; margin-left:20px;">
						<label>Middlename</label><br />
						<input type="text" value="<?php echo $fetch['middlename']; ?>" class="form-control" size="40" disabled />
					</div>
					<div class="form-inline" style="float:left; margin-left:20px;">
						<label>Lastname</label><br />
						<input type="text" value="<?php echo $fetch['lastname']; ?>" class="form-control" size="40" disabled />
					</div>

					<br style="clear:both;" /><br />

					<div class="form-inline" style="float:left;">
						<label>Room Type</label><br />
						<input type="text" value="<?php echo $fetch['room_type']; ?>" class="form-control" size="20" disabled />
					</div>
					<div class="form-inline" style="float:left; margin-left:20px;">
						<label>Room No</label><br />
						<input type="number" min="0" max="999" name="room_no" class="form-control" required />
					</div>
					<div class="form-inline" style="float:left; margin-left:20px;">
						<label>Days</label><br />
						<input type="number" min="1" max="99" name="days" class="form-control" required />
					</div>
					<div class="form-inline" style="float:left; margin-left:20px;">
						<label>Extra Bed</label><br />
						<input type="number" min="0" max="99" name="extra_bed" class="form-control" />
					</div>

					<br style="clear:both;" /><br />

					<button type="submit" name="add_form" class="btn btn-primary">
						<i class="glyphicon glyphicon-save"></i> Submit
					</button>
				</form>
			</div>
		</div>
	</div>

	<div style="text-align:right; margin-right:10px;" class="navbar navbar-default navbar-fixed-bottom">
		<label>&copy;HOR 2025 </label>
	</div>
</body>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.js"></script>	
</html>
