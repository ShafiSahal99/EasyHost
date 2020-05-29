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

		function confirmPayFee(){
			var conf = confirm('Confirm to Pay Fee.\nPay previous month fee in below section');

			if(!conf)
				return false;
		}

		function confirmPayPreviousMonthFee(){
			var conf = confirm('Confirm to Pay Fee.');

			if(!conf)
				return false;
		}
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Fee Arrears</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$getFeeArrearsQuery = "SELECT S_ID, FirstName, LastName, PreviousMonthFee, CurrentMonthFee FROM Students WHERE CurrentMonthFee = 'notpaid'";
		$getFeeArrears = mysqli_query($conn, $getFeeArrearsQuery);

		if(!$getFeeArrears){
			 echo '<b><span style="color:red"><center>No students registered</center></span></b>';
			 return;
		}

		if($getFeeArrears){
			$feeArrearsCount = mysqli_num_rows($getFeeArrears);

		}

		if($feeArrearsCount == 0)
			echo '<b><span style="color:#2db300"><center>No fee arrears in Current Month</center></span></b>';
		
	?>

	<center><h2 style="color: #ff6600">Students who not paid Current Month Fee</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Previoius Month Fee</th><th>Current Month Fee</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getFeeArrears)){ ?>	
	<tr><td><?php echo $array["S_ID"];?></td><td><?php echo $array["FirstName"];?></td><td><?php echo $array["LastName"];?></td><td><?php echo $array["PreviousMonthFee"]; ?></td><td><?php echo $array["CurrentMonthFee"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentDetails.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form name="detailsForm" class="editDeleteForm" action="Fees.php" method="POST" onsubmit="return confirmPayFee()">
	 		<input type="submit" name="payFee" class="tableSubmit" value="Pay Fee"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form  name="editForm" class="editDeleteForm" action="EditStudent.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="Students.php" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteStudent" value="<?php echo $array['S_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($getFeeArrears); ?>
</tbody>
</table>

<br><br><br><br><hr><br>

<?php
	$getExtremeFeeArrearsQuery = "SELECT S_ID, FirstName, LastName, PreviousMonthFee, CurrentMonthFee
								 FROM Students
								 WHERE PreviousMonthFee = 'notpaid' AND CurrentMonthFee = 'notpaid'";
	$getExtremeFeeArrears = mysqli_query($conn, $getExtremeFeeArrearsQuery);
	if($getExtremeFeeArrears)
		$extremeFeeArrearsCount = mysqli_num_rows($getExtremeFeeArrears);

	if($extremeFeeArrearsCount == 0)
		echo '<b><span style="color:#2db300"><center>No fee arrears in Previous Month</center></span></b>';

	if($getExtremeFeeArrears && $extremeFeeArrearsCount != 0){
		echo '<center><form action="Fees.php" name="deleteAllForm" class="editDeleteForm" onsubmit="return confirmDeleteAll()" method="POST" >
									<input type="submit" name="deleteAllPreviousMonthFee" class="normalButtonSubmit"value="Delete All">
									</center></form><br>';
	}

?>


<center><h2 style="color: #ff6600">Students who not paid Current Month Fee and Previous Month Fee</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Previoius Month Fee</th><th>Current Month Fee</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getExtremeFeeArrears)){ ?>	
	<tr><td><?php echo $array["S_ID"];?></td><td><?php echo $array["FirstName"];?></td><td><?php echo $array["LastName"];?></td><td><?php echo $array["PreviousMonthFee"]; ?></td><td><?php echo $array["CurrentMonthFee"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentDetails.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form name="detailsForm" class="editDeleteForm" action="Fees.php" method="POST" onsubmit="return confirmPayPreviousMonthFee()">
	 		<input type="submit" name="payPreviousMonthFee" class="tableSubmit" value="Pay Previous Month Fee"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form  name="editForm" class="editDeleteForm" action="EditStudent.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="Students.php" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteStudent" value="<?php echo $array['S_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($getExtremeFeeArrears); ?>
</tbody>
</table>

<?php
	$getCautionArrearsQuery = "SELECT S_ID, FirstName, LastName, PreviousMonthFee, CurrentMonthFee
							   FROM Students
							   WHERE Caution = 'notpaid'";

	$getCautionArrears = mysqli_query($conn, $getCautionArrearsQuery);
	if($getCautionArrears)
		$cautionArrearsCount = mysqli_num_rows($getCautionArrears);
?>

<br><br><br><br><hr><br>

<center><h2 style="color: #ff6600">Students who not paid Caution</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Previoius Month Fee</th><th>Current Month Fee</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getCautionArrears)){ ?>	
	<tr><td><?php echo $array["S_ID"];?></td><td><?php echo $array["FirstName"];?></td><td><?php echo $array["LastName"];?></td><td><?php echo $array["PreviousMonthFee"]; ?></td><td><?php echo $array["CurrentMonthFee"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentDetails.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form  name="editForm" class="editDeleteForm" action="EditStudent.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="Students.php" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteStudent" value="<?php echo $array['S_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($getCautionArrears); ?>
</tbody>
</table>	

</body>
</html>
