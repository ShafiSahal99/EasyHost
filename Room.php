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
	<script type="text/javascript">
		function confirmDelete(){
			var conf = confirm('Are you sure you want to delete this record permanently?');

			if (!conf)
				return false;
			
		}

		function confirmDeleteAll(){
			var conf = confirm('Are you sure you want to delete the whole entries?');

			if(!conf)
				return false;
		}

		function confirmSynchronize(){
			var conf = confirm('The current room structure will be lost.\nAre you sure you want to proceed?');

			if(!conf)
				return false;
		}

		
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Room</title>
</head>
<body>

	<?php 


		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);
		$emptyRoom = '<span style="color:black"><center>No room set</center></span';

		

		$read = "SELECT * FROM Room";
		$isRoomExist = mysqli_query($conn, $read);

		$refreshStatus = 0;


		
	?>

	<input type="hidden" id="refreshed" value="no">

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php" >New Registration</a>
			<a href="Vacancy.php">Vacancy</a>
			<a href="Students.php">Students</a>
			<a href="Room.php" class="active">Room</a>
			<a href="Fees.php">Fees</a>
		</div>
	</div>
	<br><br>
	
	
	

	<?php

	if(isset($_POST['synchronize'])){
		$deleteAllRoomQuery = "DELETE FROM Room";
		mysqli_query($conn, $deleteAllRoomQuery);

		$createRoom = "CREATE TABLE IF NOT EXISTS Room (
					RoomNumber INT(3),
					Capacity INT(1),
					CurrentStatus INT(1),
					PRIMARY KEY (RoomNumber)
				)";

		mysqli_query($conn, $createRoom);

		$getAllRoomNumberQuery = "SELECT RoomNumber FROM Students";
		$getAllRoomNumber = mysqli_query($conn, $getAllRoomNumberQuery);
		
		while($array = mysqli_fetch_array($getAllRoomNumber)){
			$roomNumber = $array['RoomNumber'];

			$insertRoomsQuery = "INSERT INTO Room (RoomNumber, Capacity, CurrentStatus) VALUES ('$roomNumber', '0', '0')";
			mysqli_query($conn, $insertRoomsQuery);

			$updateCurrentStatusQuery = "UPDATE Room SET Capacity = Capacity + 1, CurrentStatus = CurrentStatus + 1
										 WHERE RoomNumber = '$roomNumber'";
			if(!mysqli_query($conn, $updateCurrentStatusQuery)){
				echo "error" . mysqli_error($conn);
			}
		}
			
			
		


	}

	if(isset($_POST['deleteStudentInRoom'])){

			$s_id = $_POST['deleteStudent'];

			$getDeleteRoomNumberQuery = "SELECT RoomNumber FROM Students WHERE S_ID = '$s_id'";
			$getDeleteRoomNumber = mysqli_query($conn, $getDeleteRoomNumberQuery);
			$deleteRoomNumberArray = mysqli_fetch_array($getDeleteRoomNumber);
			$deleteRoomNumber = $deleteRoomNumberArray['RoomNumber'];
			$decrementCurrentStatusQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = '$deleteRoomNumber'";
			mysqli_query($conn, $decrementCurrentStatusQuery);

			$deleteStudent = "DELETE FROM Students WHERE S_ID = '$s_id'";
			mysqli_query($conn, $deleteStudent);

			echo '<b><span style="color:#2db300"><center>Student Deleted</center></span></b>';

	}

	if(isset($_POST['deleteAllStudentsInRoom'])){
			$roomNumber = $_POST['deleteAllRoomNumber'];
			$getAllRoomQuery = "SELECT RoomNumber FROM Students WHERE RoomNumber = '$roomNumber'";
			$getAllRoom = mysqli_query($conn, $getAllRoomQuery);

			while($AllRoomArray = mysqli_fetch_array($getAllRoom)){
				$currentRoomNumber = $AllRoomArray['RoomNumber'];
				$deleteRoomQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = '$currentRoomNumber'";
				mysqli_query($conn, $deleteRoomQuery);
			}

			$deleteStudentsInRoomQuery = "DELETE FROM Students WHERE RoomNumber = '$roomNumber'";
			mysqli_query($conn, $deleteStudentsInRoomQuery);
			echo '<b><span style="color:#2db300"><center>Students Deleted</center></span></b>';

		}

	if (isset($_POST['deleteAll'])){
		$deleteAllRoom = "DROP TABLE Room";
		mysqli_query($conn, $deleteAllRoom);
		//header("Refresh:0");
	}
	
	if (isset($_POST['editRoom'])){
		$roomNum = mysqli_real_escape_string($conn, $_POST['roomNum']);
		$editCapacity = mysqli_real_escape_string($conn, $_POST['editCapacity']);
		$updateRoom = "UPDATE Room
					   SET Capacity = $editCapacity
					   WHERE RoomNumber = $roomNum";

		mysqli_query($conn, $updateRoom);
	}
	

	if (isset($_POST['delete'])){
		$deleteRoomNumber = $_POST['deleteRoomNumber'];
		$deleteRoom = "DELETE FROM Room WHERE RoomNumber = $deleteRoomNumber";
		mysqli_query($conn, $deleteRoom);
	}

	

	if(isset($_POST['addRoom'])){
	$roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);
	$capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
	$roomSuccess = '<b><span style="color:#2db300"><center>Room added </center></span></b>';
	$roomFail='<b><span style="color:red"><center>Room already exists</center></span></b>';
	
  
  	$createRoom = "CREATE TABLE IF NOT EXISTS Room (
					RoomNumber INT(3),
					Capacity INT(1),
					CurrentStatus INT(1),
					PRIMARY KEY (RoomNumber)
				)";

	mysqli_query($conn, $createRoom);	

	

	 $checkExist = "SELECT RoomNumber FROM Room WHERE RoomNumber = '$roomNumber' ";
	 $result = mysqli_query($conn, $checkExist);
	 $room = mysqli_fetch_assoc($result);

	 if($room['RoomNumber'] == $roomNumber){
		echo $roomFail;
	}else{
		$insertRoom = "INSERT INTO Room VALUES ('$roomNumber', '$capacity', '0')";
		mysqli_query($conn, $insertRoom);

		echo $roomSuccess;
	}
}

$read = "SELECT * FROM Room";
$result = mysqli_query($conn, $read);
?>


<?php

if (!$result){
	echo '<b><span style="color:red"><center>No room set</center></span></b>'; 
	?>
	<br>
	<center><input type="button" name="addRoom" class="normalButton" value="Add Room" onclick="window.location.href='AddRoom.php'"> 
	<form name="snchronizeForm" class="editDeleteForm" action="Room.php" onsubmit="return confirmSynchronize()" method="post">	
		<input type="submit" name="synchronize" class="normalButtonSubmit" value="Auto Fill">
	</form></center>
<?php }else{ ?>

	<br><center><input type="button" name="addRoom" class="normalButton" value="Add Room" onclick="window.location.href='AddRoom.php'"> 
	<form name="snchronizeForm" class="editDeleteForm" action="Room.php" onsubmit="return confirmSynchronize()" method="post">	
		<input type="submit" name="synchronize" class="normalButtonSubmit" value="Auto Fill">
	</form>

<?php
	echo '<form action="Room.php" name="deleteAllForm" class="editDeleteForm" onsubmit="return confirmDeleteAll()" method="POST" >
									<input type="submit" name="deleteAll" class="normalButtonSubmit"value="Delete All">
									</center></form>';

?>



		
<center><h2 style="color: #ff6600">Room Details</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Room Number</th><th>Capacity</th><th>Curent Status</th><th>Vacancy</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($result)){ ?>	
	<tr><td><?php echo $array["RoomNumber"];?></td><td><?php echo $array["Capacity"];?></td><td><?php echo $array["CurrentStatus"];?></td><td><?php echo $array["Capacity"]-$array["CurrentStatus"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentsInRoom.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="detailsRoomNumber" value="<?php echo $array['RoomNumber'];?>">
	 	</form>

	 	<form  name="editForm" class="editDeleteForm" action="EditRoom.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="roomNumber" value="<?php echo $array['RoomNumber'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteRoomNumber" value="<?php echo $array['RoomNumber'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php   } mysqli_free_result($result);} ?>



<?php mysqli_close($conn); ?>
</tbody>
</table>




</body>
</html>
