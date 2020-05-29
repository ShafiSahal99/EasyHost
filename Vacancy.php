<?php
session_start();  

if(isset($_SESSION['user']) && $_SESSION['loggedin'] == true ){
		
	}else{
		header("location: login.php");
		exit;
	}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Vacancy</title>
</head>
<body>

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php" >New Registration</a>
			<a href="Vacancy.php" class="active">Vacancy</a>
			<a href="Students.php">Students</a>
			<a href="Room.php">Room</a>
			<a href="Fees.php">Fees</a>
		</div>
	</div>
	<br><br>

	<?php 
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$isRoomAvailableQuery = "SELECT * FROM Room";
		$isRoomAvailable = mysqli_query($conn, $isRoomAvailableQuery);

		if(!$isRoomAvailable){
			echo '<b><span style="color:red"><center>No room set</center></span></b>';
			return;
		}

		$getVacantRoomsQuery = "SELECT * FROM Room WHERE Capacity-CurrentStatus > 0";
		$getVacantRooms = mysqli_query($conn, $getVacantRoomsQuery);
		$availableRoomCount = mysqli_num_rows($getVacantRooms);
		$availableSpaceCount = 0;

		if ($availableRoomCount == 0){
			echo '<b><span style="color:red"><center>No space available</center></span></b>';
		}else{
			$getVacanyQuery = "SELECT Capacity-CurrentStatus FROM Room WHERE Capacity-CurrentStatus > 0";
			$getVacancy = mysqli_query($conn, $getVacanyQuery);

			while($availableSpaceArray = mysqli_fetch_array($getVacancy)){
				$availableSpaceCount += $availableSpaceArray['Capacity-CurrentStatus'];
			
			}


		echo '<b><center><span style="color:#2db300">Available spaces: '.$availableSpaceCount.'</span></center></b><br>';
		echo '<b><center><span style="color:#2db300">Available rooms: '.$availableRoomCount.'</span></center></b><br>';
		}

	?>

	
<center><h2 style="color: #ff6600">Vacant Rooms</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Room Number</th><th>Capacity</th><th>Curent Status</th><th>Vacancy</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getVacantRooms)){ ?>	
	<tr><td><?php echo $array["RoomNumber"];?></td><td><?php echo $array["Capacity"];?></td><td><?php echo $array["CurrentStatus"];?></td><td><?php echo $array["Capacity"]-$array["CurrentStatus"]; ?></td>  
	 
	 		
   </tr>
   <?php }mysqli_free_result($getVacantRooms); mysqli_free_result($isRoomAvailable); ?>
</tbody></table>

</body>
</html>
