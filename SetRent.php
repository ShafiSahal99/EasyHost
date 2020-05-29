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
	<title>Set Rent</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<center><form name="RoomForm" class="normalForm" action="Fees.php"  method="post">
	<center><table cellspacing="0">
			<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Set Rent</h2></th>
		<tr><td align="center">Rent(Monthly):</td><td><input type="number" name="rent" autofocus required ></td></tr>
		<tr><td><br><br><br></td></tr>
       
		<tr><td colspan="2" align="center"><input type="submit" class="normalSubmit" name="setRent" value="   Set   "><br><br><br><br></td>
		
	</table></tbody></center>	

</form></center>

</body>
</html>
