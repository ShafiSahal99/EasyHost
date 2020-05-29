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
	<title>Edit Room</title>
</head>
<body>

	<?php
	$serverName = "localhost";
	$user = "root";
	$pass = "";
	$db = "Hostel";
	$conn = mysqli_connect($serverName, $user, $pass, $db);
	$roomNumber = $_POST['roomNumber'];
	?>

	<h1>Hostel Management System</h1><br><br>

	<center><form name="editRoomForm" class="normalForm" action="Room.php"  method="post">
	<center><table cellspacing="0">
			<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Edit Room</h2></th>
		<tr><td align="center">Room Number:</td><td style="color: #009933"><?php echo "<b>" . $roomNumber . "</b>"; ?></td></tr>
		<tr><td align="center">Capacity:</td><td><input type="number" name="editCapacity" autofocus required>
			<input type="hidden" name="roomNum" value="<?php echo $roomNumber;?>"></td></tr>
		<tr><td><br><br><br></td></tr>
       
		<tr><td colspan="2" align="center"><input type="submit" class="normalSubmit" name="editRoom" value="   Done   "><br><br><br><br>
		</td></tr>

		
	</table></tbody></center>	
</form></center>

</body>
</html>
