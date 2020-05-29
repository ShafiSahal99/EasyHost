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
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Fees</title>
</head>
<body>

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php" >New Registration</a>
			<a href="Vacancy.php">Vacancy</a>
			<a href="Students.php">Students</a>
			<a href="Room.php">Room</a>
			<a href="Fees.php" class="active">Fees</a>
		</div>
	</div>
	<br><br><br>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$getOtherFeesQuery = "SELECT * FROM Fees ORDER BY Fee_ID DESC ";
		$getOtherFees = mysqli_query($conn, $getOtherFeesQuery);
		if(!$getOtherFeesQuery){
			$OtherFeesCount = mysqli_num_rows($getOtherFees);
		}

		if(isset($_POST['deleteAllPreviousMonthFee'])){
			$getAllRoomQuery = "SELECT RoomNumber FROM Students WHERE PreviousMonthFee = 'notpaid' AND CurrentMonthFee = 'notpaid'";
			$getAllRoom = mysqli_query($conn, $getAllRoomQuery);

			while($AllRoomArray = mysqli_fetch_array($getAllRoom)){
				$currentRoomNumber = $AllRoomArray['RoomNumber'];
				$deleteRoomQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = '$currentRoomNumber'";
				mysqli_query($conn, $deleteRoomQuery);
			}

			$deleteExtremeFeeArrearsQuery = "DELETE FROM Students WHERE PreviousMonthFee = 'notpaid' AND CurrentMonthFee = 'notpaid'";
			mysqli_query($conn, $deleteExtremeFeeArrearsQuery);

			echo '<b><span style="color:#2db300"><center>Students with previous and current month fee arrears deleted</center></span></b>';
		}

		if(isset($_POST['payPreviousMonthFee'])){
			$s_id = $_POST['s_id'];

			$payPreviousMonthFeeQuery = "UPDATE Students SET PreviousMonthFee = 'paid' WHERE S_ID = '$s_id'";
			mysqli_query($conn, $payPreviousMonthFeeQuery);

			echo '<b><span style="color:#2db300"><center>Payment entered</center></span></b>';
		}

		if(isset($_POST['payFee'])){
			$s_id = $_POST['s_id'];
			
			$payFeeQuery = "UPDATE Students SET CurrentMonthFee = 'paid' WHERE S_ID = '$s_id'";
			mysqli_query($conn, $payFeeQuery);

			echo '<b><span style="color:#2db300"><center>Payment entered</center></span></b>';
		}
		
		if(isset($_POST['deleteAll'])){
			$deleteAllOtherFeesQuery = "DROP TABLE Fees";
			mysqli_query($conn, $deleteAllOtherFeesQuery);
		}

		if(isset($_POST['delete'])){
			$fee_id = $_POST['deleteOtherFees'];
			$deleteOtherFeesQuery = "DELETE FROM Fees WHERE FEE_ID ='$fee_id'";
			mysqli_query($conn, $deleteOtherFeesQuery);
		}

		if(isset($_POST['editOtherFees'])){

			$fee_id = $_POST['fee_id'];
			$month = mysqli_real_escape_string($conn, $_POST['month']);
			$year = mysqli_real_escape_string($conn, $_POST['year']);
			$messFee = mysqli_real_escape_string($conn, $_POST['messFee']);
			$electricityFee = mysqli_real_escape_string($conn, $_POST['electricityFee']);

			$isFeesDuplicateQuery = "SELECT * FROM Fees WHERE Month = '$month' AND Year = '$year' AND FEE_ID <> '$fee_id'";
			$isFeesDuplicate  = mysqli_query($conn, $isFeesDuplicateQuery);
			$FeesDuplicateCount = mysqli_num_rows($isFeesDuplicate);

			if($FeesDuplicateCount == 0){

				$editOtherFeesQuery = "UPDATE Fees SET Month = '$month',
												   Year = '$year',
												   MessFee = '$messFee',           
												   ElectricityFee = '$electricityFee'
											   WHERE Month = '$month' AND Year = '$year'";

				mysqli_query($conn, $editOtherFeesQuery);
				echo '<b><span style="color:#2db300"><center>Changes saved</center></span></b><br>';
				
			}else{
			echo '<b><span style="color:red"><center>Changes not saved</center><center>Duplicate entry found</center></span></b><br>';
		}
		}

		if(isset($_POST['setOtherFees'])){

			$createFeesTableQuery = "CREATE TABLE IF NOT EXISTS Fees (
									 FEE_ID INT(10) NOT NULL AUTO_INCREMENT,
									 Month VARCHAR(20),
									 Year VARCHAR(20),
									 MessFee VARCHAR(4),
									 ElectricityFee VARCHAR(4),
									 PerHead VARCHAR(4),
									 PRIMARY KEY (FEE_ID)
									)";

			mysqli_query($conn, $createFeesTableQuery);

			if(!mysqli_query($conn, $createFeesTableQuery)){
				echo "Error: " . mysqli_error($conn);
			}

			$month = mysqli_real_escape_string($conn, $_POST['month']);
			$year = mysqli_real_escape_string($conn, $_POST['year']);
			$messFee = mysqli_real_escape_string($conn, $_POST['messFee']);
			$electricityFee = mysqli_real_escape_string($conn, $_POST['electricityFee']);

			$getRentQuery = "SELECT Rent FROM Admin";
			$rent = mysqli_query($conn, $getRentQuery);
			$rentArray = mysqli_fetch_array($rent);

			$totalFee = ($messFee + $electricityFee + $rentArray['Rent']);
			
			$getAllStudentsQuery = "SELECT S_ID FROM Students";
			$getAllStudents = mysqli_query($conn, $getAllStudentsQuery);
			if($getAllStudents)
				$allStudentsList = mysqli_num_rows($getAllStudents);
			else
				$allStudentsList = 1;

			$perHead = $totalFee / $allStudentsList;

			$isDuplicateFeesQuery = "SELECT Month, Year FROM Fees WHERE Month = '$month' AND Year = '$year'";
			$isDuplicateFees = mysqli_query($conn, $isDuplicateFeesQuery);
			$isDuplicateFeesCount = mysqli_num_rows($isDuplicateFees);

			if($isDuplicateFeesCount == 0){

			$insertOtherFeesQuery = "INSERT INTO Fees (Month, Year, MessFee, ElectricityFee, PerHead) VALUES ('$month', '$year', '$messFee', '$electricityFee', '$perHead')";
			mysqli_query($conn, $insertOtherFeesQuery);

			$updatePreviousMonthFeesQuery = "UPDATE Students SET PreviousMonthFee = CurrentMonthFee, CurrentMonthFee = 'notpaid'";
			mysqli_query($conn, $updatePreviousMonthFeesQuery);

			echo '<b><span style="color:#2db300"><center>Other fees added</center></span></b><br>';
			}else{
				echo '<b><span style="color:red"><center>Other fees not added</center><center>Duplicate entry found</center></span></b><br>';
			}
		}

		if(isset($_POST['setRent'])){
			$rent = mysqli_real_escape_string($conn, $_POST['rent']);
			$insertRentQuery = "UPDATE Admin SET Rent = '$rent'";
			mysqli_query($conn, $insertRentQuery);
		} 

		$isFeesExistQuery = "SELECT Rent FROM Admin WHERE Name = 'admin'";
		$isFeesExist = mysqli_query($conn, $isFeesExistQuery);
		$FeesExistArray = mysqli_fetch_array($isFeesExist);

		$getAllStudentsQuery = "SELECT S_ID FROM Students";
		$getAllStudents = mysqli_query($conn, $getAllStudentsQuery);

		$getOtherFeesQuery = "SELECT * FROM Fees ORDER BY Fee_ID DESC ";
		$getOtherFees = mysqli_query($conn, $getOtherFeesQuery);
		if($getOtherFees)
			$OtherFeesCount = mysqli_num_rows($getOtherFees);

		if($FeesExistArray['Rent'] == "0")
			header("location:SetRent.php");
		
	?>

	<center><input type="button" name="setRent" class="normalButton" value="Change Rent" onclick="window.location.href='SetRent.php'">
	<input type="button" name="setOtherFees" class="normalButton" value="Add other fees" onclick="window.location.href='AddOtherFees.php'">
	<input type="button" name="Fee arrears" class="normalButton" value="See Fee Arrears" onclick="window.location.href='FeeArrears.php'">
	<?php if($getOtherFees && $OtherFeesCount != 0){
		echo '<form action="Fees.php" name="deleteAllForm" class="editDeleteForm" onsubmit="return confirmDeleteAll()" method="POST" >
									<input type="submit" name="deleteAll" class="normalButtonSubmit"value="Delete All">
									</center></form><br>';
	}
	?>

	<?php

		$getAllStudentsQuery = "SELECT S_ID FROM Students";
		$getAllStudents = mysqli_query($conn, $getAllStudentsQuery);
		if($getAllStudents)
			$allStudentsList = mysqli_num_rows($getAllStudents);

		$getRentQuery = "SELECT Rent FROM Admin";
		$rent = mysqli_query($conn, $getRentQuery);
		$rentArray = mysqli_fetch_array($rent);

		echo '<br><br><b><span style="color:#2db300"><center>Current Rent:'." ".$rentArray['Rent'].'</center></span></b>';

		if(!$getOtherFees)
			return;

		$OtherFeesCount = mysqli_num_rows($getOtherFees);

		if($OtherFeesCount == 0){
			return;
		}else{
			
			$getOtherFeesQuery = "SELECT * FROM Fees ORDER BY Fee_ID DESC ";
			$getOtherFees = mysqli_query($conn, $getOtherFeesQuery);
			if($getOtherFees)
				$OtherFeesCount = mysqli_num_rows($getOtherFees);
		}


	?>

	<center><h2 style="color: #ff6600">Other Fees Details</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Month</th><th>Year</th><th>Mess Fee</th><th>Electricity Fee</th><th>Amount Per Student</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getOtherFees)){ ?>	
	<tr><td><?php echo $array["Month"];?></td><td><?php echo $array["Year"];?></td><td><?php echo $array["MessFee"];?></td><td><?php echo $array["ElectricityFee"]; ?></td><td>
		<?php 

			if($getAllStudents && $allStudentsList != 0){
				echo ($rentArray['Rent'] + $array['MessFee'] + $array['ElectricityFee']) / $allStudentsList;
			}else{
				echo $array['PerHead'];
			}
		 ?></td>  
	 <td>

	 	<form  name="editForm" class="editDeleteForm" action="EditOtherFees.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="fee_id" value="<?php echo $array['FEE_ID'];?>">
	 		<input type="hidden" name="month" value="<?php echo $array['Month'];?>">
	 		<input type="hidden" name="year" value="<?php echo $array['Year'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteOtherFees" value="<?php echo $array['FEE_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($getOtherFees); ?>
</tbody>
</table>	

</body>
</html>
