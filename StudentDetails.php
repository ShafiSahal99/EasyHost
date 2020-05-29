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
	<title>Student Details</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";


		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$s_id = $_POST['s_id'];


		$studentDetailsQuery = "SELECT * FROM Students WHERE S_ID = $s_id";
		$studentDetails = mysqli_query($conn, $studentDetailsQuery);

		

	?>

	<center><h2 style="color: #ff6600">Student Details</h2></center>

	<center><table cellspacing="0"> 
		<tbody class="profileTable">
		<center><tbody class="detailsTable">
			<?php while ($array = mysqli_fetch_array($studentDetails)) {?>
				<tr><td>First Name:</td><td align="left"><?php echo $array["FirstName"];  ?></td></tr>
				<tr><td>Last Name: </td><td><?php echo $array["LastName"]; ?></td></tr>
				<tr><td>Date of Birth: </td><td><?php echo $array["DOB"]; ?></td></tr>
				<tr><td>House Name: </td><td><?php echo $array["HouseName"]; ?></td></tr>
				<tr><td>District: </td><td><?php echo $array["District"]; ?></td></tr>
				<tr><td>Pin: </td><td><?php echo $array["PIN"]; ?></td></tr>
				<tr><td>Date of Join: </td><td><?php echo $array["JoinDate"]; ?></td></tr>
				<tr><td>Caution: </td><td><?php echo $array["Caution"]; ?></td></tr>
				<tr><td>Mobile Number: </td><td><?php echo $array["MobileNumber"]; ?></td></tr>
				<tr><td>Guardian Name: </td><td><?php echo $array["GuardianName"]; ?></td></tr>
				<tr><td>Room Number: </td><td><?php echo $array["RoomNumber"]; ?></td></tr>
				<tr><td>Password: </td><td><?php echo $array["Password"]; ?></td></tr>
				<tr><td>Previous Month Fee: </td><td><?php echo $array["PreviousMonthFee"]; ?></td></tr>
				<tr><td>Current Month Fee: </td><td><?php echo $array["CurrentMonthFee"]; ?></td></tr>
			<?php } ?>
	</tbody></center>
</table></center>

<br><br><br>

</body>
</html>
