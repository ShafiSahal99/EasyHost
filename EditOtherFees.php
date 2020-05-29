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
	<title>Edit Other Fees</title>
</head>
<body>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$fee_id = $_POST['fee_id'];
		$month = $_POST['month'];
		$year = $_POST['year'];

		$getOtherFeesQuery = "SELECT * FROM Fees WHERE Month = '$month' AND Year = '$year'";
		$getOtherFees = mysqli_query($conn, $getOtherFeesQuery);
		$otherFeesArray = mysqli_fetch_array($getOtherFees);
	?>

	<h1>Hostel Management System</h1>

	<center><form name="RoomForm" class="normalForm" action="Fees.php"  method="post">
	<center><table cellspacing="0">
			<tbody class="formTable">
		<th colspan="2" align="center" style="color: black"><h2>Edit Other Fees</h2></th>
		<tr><td align="center">Month:</td><td><input type="text" name="month" value="<?php echo $otherFeesArray['Month'] ?>" autofocus required ></td></tr>
		<tr><td align="center">Year:</td><td><input type="number" name="year" value="<?php echo $otherFeesArray['Year'] ?>" required></td></tr>
		<tr><td align="center">Mess Fee:</td><td><input type="number" name="messFee" value="<?php echo $otherFeesArray['MessFee'] ?>" required></td></tr>
		<tr><td align="center">Electricity Fee:</td><td><input type="number" name="electricityFee" value="<?php echo $otherFeesArray['ElectricityFee'] ?>" required></td></tr>
		<td><input type="hidden" name="fee_id" value="<?php echo $fee_id ?>"></td>
		<tr><td><br><br><br></td></tr>
       
		<tr><td colspan="2" align="center"><input type="submit" class="normalSubmit" name="editOtherFees" value="   Set   "><br><br><br><br></td>
		
	</table></tbody></center>	

</form></center>

</body>
</html>
