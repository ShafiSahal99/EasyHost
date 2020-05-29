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
		
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title></title>
</head>
<body>

	<?php

	$serverName = "localhost";
	$user = "root";
	$pass = "";
	$db = "Hostel";


	$conn = mysqli_connect($serverName, $user, $pass, $db);

	$createRoom = "CREATE TABLE IF NOT EXISTS Vacancy (
					RoomNumber INT(3),
					Capacity INT(1),
					CurrentStatus INT(1),
					PRIMARY KEY (roomNumber)
				)";

	mysqli_query($conn, $createRoom);
	mysqli_close($conn);

	?>


	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php" >New Registration</a>
			<a href="Vacate.php">Vacate</a>
			<a href="Students.php">Students</a>
			<a href="Room.php" class="active">Room Setup</a>
			<a href="Mess.php">Mess</a>
		</div>
	</div>
	<br><br>



<?php

$roomNum = "";
	$capacity = "";
	$roomSuccess = "";
	$roomFail = "";
	$count = 0;

	$conn = mysqli_connect($serverName, $user, $pass, $db);

if (isset($_POST['reg'])){

	$roomNum = $_POST['roomNumber'];
  		$capacity = $_POST['capacity'];
  		$roomSuccess = '<span style="color:#2db300"><center>Room Added Successfully</center></span';
  		$roomFail = '<span style="color:red"><center>Room Already Exists</center></span';	

  		
 	 $checkExist = "SELECT * FROM Vacancy WHERE RoomNumber = '$roomNum' ";

	$result = mysqli_query($conn, $checkExist);
	$room = mysqli_fetch_assoc($result);

	if($room['RoomNumber'] == $roomNum){
		echo $roomFail;
	}else{
		$insertRoom = "INSERT INTO Vacancy VALUES ('$roomNum', '$capacity', '0')";
		echo "<meta http=equiv='refresh' content='0'>";
		mysqli_query($conn, $insertRoom);

		echo $roomSuccess;
	}

}

function test_input($data) {
 	  $data = trim($data);
	  $data = stripslashes($data);
 	  $data = htmlspecialchars($data);
 	 return $data;
 	 }
 	 ?>

<?php

	
	
?>

	<form name="RoomForm" action="RoomSetup.php"  method="post">
	<center><table>
		<th colspan="2" align="center" style="color: black"><h2>Room Setup</h2></th>
		<tr><td>Room Number:</td><td><input type="number" name="roomNumber" required ></td></tr>
		<tr><td>Capacity:</td><td><input type="number" name="capacity" required></td></tr>
		
        <tr><td><br><br></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" name="reg" value="   Add Room   "></td>
		<tr><td><br><br></td></tr>
	</table></center>	
</form>



</body>
</html>
