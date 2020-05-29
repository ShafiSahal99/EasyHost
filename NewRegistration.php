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

	<script type="text/javascript">
		function validateForm(){
			var firstName = document.forms["RegForm"]["firstName"];
			var lastName = document.forms["RegForm"]["lastName"];
			var houseName = document.forms["RegForm"]["houseName"];
			var district = document.forms["RegForm"]["district"];
			var pin = document.forms["RegForm"]["pin"];
			var caution = document.forms["RegForm"]["caution"];
			var roomNumber = document.forms["RegForm"]["roomNumber"];
			var password = document.forms["RegForm"]["password"];
			var mobileNumber = document.forms["RegForm"]["mobileNumber"].value;

			if(Number.isNan(pin.value)){
				alert("Enter a valid PIN");
				pin.focus();
			}			

			if(mobileNumber.length != 10){
				alert("Mobile number must be atleast 10 digits")
				return false;
				mobileNumber.focus();
			}

			var d = new Date("2015-03-25");
			document.getElementById("dob").innerHTML = d;

		}
	</script>

	<title>New Registration</title>
</head>
<body>

	<?php

	$serverName = "localhost";
	$user = "root";
	$pass = "";
	$db = "Hostel";


	$conn = mysqli_connect($serverName, $user, $pass, $db);

	?>

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php" class="active">New Registration</a>
			<a href="Vacancy.php">Vacancy</a>
			<a href="Students.php">Students</a>
			<a href="Room.php">Room</a>
			<a href="Fees.php">Fees</a>
		</div>
	</div>
	<br><br>

	<?php 
		$read = "SELECT * FROM Room";
		$isRoomSet = mysqli_query($conn, $read);

		if(!$isRoomSet){
			echo '<b><span style="color:red"><center>No room set</center></span><br><span style="color:red"><center>Please set room to register</center></span></b><br>';
			return;
			
		}

		if($isRoomSet){
		$isRoomAvailable = "SELECT RoomNumber FROM Room WHERE Capacity-CurrentStatus > 0";
		$availableRoomList = mysqli_query($conn, $isRoomAvailable);
		$availableRoomCount = mysqli_num_rows($availableRoomList);
		if ($availableRoomCount == 0){
			echo '<b><span style="color:red"><center>No space available</center><br><center>Check Vacancy for more details</center></span></b><br>';
			
		}else{

		$availableSpace = "SELECT Capacity-CurrentStatus FROM Room WHERE Capacity-CurrentStatus > 0";
		$availableSpaceList = mysqli_query($conn, $availableSpace);
		$availableSpaceCount = 0;
		while($availableSpaceArray = mysqli_fetch_array($availableSpaceList)){
			$availableSpaceCount += $availableSpaceArray['Capacity-CurrentStatus'];
		}
			
		

		
		echo '<b><center><span style="color:#2db300">Available spaces: '.$availableSpaceCount.'</span></center></b><br>';
	}
	}

	?>

	<center><form action="Students.php" name="RegForm" width="100%"onsubmit="return validateForm()" class="normalForm" method="POST">
	<center><table cellspacing="0">
		<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>New Registration</h2></th>
		<tr><td align="center">First Name:</td><td><input type="text" name="firstName" autofocus required ></td></tr>
		<tr><td align="center">Last Name:</td><td><input type="text" name="lastName" required></td></tr>
		<tr><td align="center">Date of Birth:</td><td><input type="date"name="dob" id="dob" required></td></tr>
        <tr><td align="center">House Name:</td><td><input type="text" name="houseName" required></td></tr>
        <tr><td align="center">District:</td><td><input type="text" name="district" required></td></tr>
        <tr><td align="center">PIN:</td><td><input type="number" name="pin" required></td></tr>
        <tr><td align="center">Date of Admission:</td><td><input type="date" name="joinDate" required></td></tr>
        <tr><td align="left">Caution:</td><td><input type="radio" name="caution" value="paid" checked required>Paid
        	<input type="radio" name="caution" value="notpaid">Not Paid</td></tr>
        <tr><td align="center">Mobile Number:</td><td><input type="number" name="mobileNumber" required></td></tr>
        <tr><td align="center">Guardian Name:</td><td><input type="text" name="guardianName" required></td></tr>
        <tr><td align="center">Guardian Mobile:</td><td><input type="number" name="guardianMobileNumber" required></td></tr>
        <tr><td align="center">Room Number:</td><td><input type="number" name="roomNumber" required></td></tr>
        <tr><td align="center">Password:</td><td><input type="password"name="password" required></td></tr>
        <tr><td><br><br></td></tr>
		<tr><td colspan="2"  align="center"><input type="submit" name="register" class="normalSubmit" value="   Register   "><br><br><br><br></td>
		
	</tbody>
	</table></center>	
</form></center>

</body>
</html>
