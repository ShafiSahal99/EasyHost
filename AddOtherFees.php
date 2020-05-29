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
	<title>Add Other Fees</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<center><form name="RoomForm" class="normalForm" action="Fees.php"  method="post">
	<center><table cellspacing="0">
			<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Other Fees</h2></th>
		<tr><td align="center">Month:</td><td><input type="text" name="month" autofocus required ></td></tr>
		<tr><td align="center">Year:</td><td><input type="number" name="year" required></td></tr>
		<tr><td align="center">Mess Fee:</td><td><input type="number" name="messFee" required></td></tr>
		<tr><td align="center">Electricity Fee:</td><td><input type="number" name="electricityFee" required></td></tr>
		<tr><td><br><br><br></td></tr>
       
		<tr><td colspan="2" align="center"><input type="submit" class="normalSubmit" name="setOtherFees" value="   Set   "><br><br><br><br></td>
		
	</table></tbody></center>	

</form></center>

</body>
</html>
