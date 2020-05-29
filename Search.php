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
		function validateForm(){
			var firstName = document.forms["SearchForm"]["firstName"].value;
			var lastName = document.forms["SearchForm"]["lastName"].value;
			var dob = document.forms["SearchForm"]["dob"].value;
			var mobileNumber = document.forms["SearchForm"]["mobileNumber"].value;
			var houseName = document.forms["SearchForm"]["houseName"].value;
			var district = document.forms["SearchForm"]["district"].value;
			var joinDate = document.forms["SearchForm"]["joinDate"].value;
			var roomNumber = document.forms["SearchForm"]["roomNumber"].value;

			if (firstName == "" && lastName == "" && dob == "" && mobileNumber == "" && houseName == "" && district == "" && joinDate == "" && roomNumber == ""){
				alert("Enter atleast one field");
				document.forms["SearchForm"]["firstName"].focus();
				return false;
			}
		}
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Search</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<center><form name="SearchForm" class="normalForm" onsubmit="return validateForm()" action="SearchResult.php" method="post">
	<center><table cellspacing="0">
			<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Search Students</h2></th>
		<tr><td colspan="2">Enter any of the following details</td></tr>
		<tr><td align="center">First Name:</td><td><input type="text" name="firstName" autofocus ></td></tr>
		<tr><td align="center">Last Name:</td><td><input type="text" name="lastName"></td></tr>
		<tr><td align="center">Date of Birth:</td><td><input type="date" name="dob"></td></tr>
		<tr><td align="center">Mobile Number:</td><td><input type="number" name="mobileNumber"></td></tr>
		<tr><td align="center">House Name:</td><td><input type="text" name="houseName"></td></tr>
		<tr><td align="center">District:</td><td><input type="text" name="district"></td></tr>
		<tr><td align="center">Date of Admission:</td><td><input type="date" name="joinDate"></td></tr>
		<tr><td align="center">Room Number:</td><td><input type="number" name="roomNumber"></td></tr>
		
		<tr><td><br><br><br></td></tr>
       
		<tr><td colspan="2" align="center"><input type="submit" class="normalSubmit" name="search" value="   Search   "><br><br><br><br></td>
		
	</table></tbody></center>	

</form></center>

</body>
</html>
