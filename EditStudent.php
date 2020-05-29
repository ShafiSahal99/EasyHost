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
	<title>Edit Student</title>
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
		$studentDetailsArray = mysqli_fetch_array($studentDetails);

	?>

	<center><form action="Students.php" name="RegForm" width="100%"onsubmit="return validateForm()" class="normalForm" method="POST">
	<center><table cellspacing="0">
		<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Edit Student</h2></th>
		<tr><td align="center">First Name:</td><td><input type="text" name="firstName" value="<?php echo $studentDetailsArray["FirstName"] ?>" autofocus required ></td></tr>
		<tr><td align="center">Last Name:</td><td><input type="text" name="lastName" value="<?php echo $studentDetailsArray["LastName"] ?>" required></td></tr>
		<tr><td align="center">Date of Birth:</td><td><input type="date"name="dob" value="<?php echo $studentDetailsArray["DOB"] ?>" required></td></tr>
        <tr><td align="center">House Name:</td><td><input type="text" name="houseName" value="<?php echo $studentDetailsArray["HouseName"] ?>" required></td></tr>
        <tr><td align="center">District:</td><td><input type="text" name="district" value="<?php echo $studentDetailsArray["District"] ?>" required></td></tr>
        <tr><td align="center">PIN:</td><td><input type="number" name="pin" value="<?php echo $studentDetailsArray["PIN"] ?>" required></td></tr>
        <tr><td align="center">Date of Admission:</td><td><input type="date" name="joinDate" value="<?php echo $studentDetailsArray["JoinDate"] ?>" required></td></tr>
        <tr><td align="left">Caution:</td><td><input type="radio" name="caution" value="paid" checked required>Paid
        	<input type="radio" name="caution" value="notpaid">Not Paid</td></tr>
        <tr><td align="center">Mobile Number:</td><td><input type="number" name="mobileNumber" value="<?php echo $studentDetailsArray["MobileNumber"] ?>"required></td></tr>
        <tr><td align="center">Guardian Name:</td><td><input type="text" name="guardianName" value="<?php echo $studentDetailsArray["GuardianName"] ?>" required></td></tr>
        <tr><td align="center">Guardian Mobile:</td><td><input type="number" name="guardianMobileNumber" value="<?php echo $studentDetailsArray["GuardianMobileNumber"] ?>" required></td></tr>
        <tr><td align="center">Room Number:</td><td><input type="number" name="roomNumber" value="<?php echo $studentDetailsArray["RoomNumber"] ?>" required></td></tr>
        <tr><td align="center">Password:</td><td><input type="password"name="password" value="<?php echo $studentDetailsArray["Password"] ?>" required></td>
        	<td><input type="hidden" name="s_id" value="<?php echo $s_id ?>">
        </tr>
        <tr><td><br><br></td></tr>
		<tr><td colspan="2"  align="center"><input type="submit" name="editStudent" class="normalSubmit" value="   Done   "><br><br><br><br></td>
		
	</tbody>
	</table></center>	
</form></center>

</body>
</html>
