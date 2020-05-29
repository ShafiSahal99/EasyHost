<?php session_start();
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
	<title> Fee </title>
</head>
<body>

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-centered">
			<a href="StudentProfile.php">Home</a>
			<a href="StudentFee.php" class="active">Fees</a>
		</div>
	</div>

	<br><br>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$s_id = $_SESSION["user"];
		$currentMonthFee = 0;
		$previousMonthFee = 0;

		$getOtherFeesQuery = "SELECT MessFee, ElectricityFee FROM Fees";
		$getOtherFees = mysqli_query($conn, $getOtherFeesQuery);
		if($getOtherFees)
			$otherFeesCount = mysqli_num_rows($getOtherFees);
		
		if($getOtherFees){
			while($getOtherFeesArray = mysqli_fetch_array($getOtherFees)){
				$messFee = $getOtherFeesArray['MessFee'];
				$electricityFee = $getOtherFeesArray['ElectricityFee'];
			}	
		}

		$getRentQuery = "SELECT Rent FROM Admin";
		$getRent = mysqli_query($conn, $getRentQuery);
		if($getRent)
			$RentCount = mysqli_num_rows($getRent);
		$rentArray = mysqli_fetch_array($getRent);
		$rent = $rentArray['Rent'];

		$getFeeArrearsQuery = "SELECT CurrentMonthFee, PreviousMonthFee FROM Students
							   WHERE S_ID = '$s_id'";
		$getFeeArrears = mysqli_query($conn, $getFeeArrearsQuery);
		if($getFeeArrears){
			$feeArrearsCount = mysqli_num_rows($getFeeArrears);
			$getFeeArrearsArray = mysqli_fetch_array($getFeeArrears);
			$currentMonthFee = $getFeeArrearsArray['CurrentMonthFee'];
			$previousMonthFee = $getFeeArrearsArray['PreviousMonthFee'];
		}


		

	?>

	<br><br><br>

	<div class="homePageStyle">
		<?php 
		echo '<br>';

		echo '<center><h2 style="color: #ff6600">Fees of this month</h2></center>';

		echo '<br><br>';
		echo 'Rent:'," ";

		if(!$getRent || $RentCount == 0)
			echo 'None<br>';
		else
	 		echo '', $rent, '<br>';

		echo '<br><br>';
	
		echo 'Mess Fee:'," ";

		if(!$getOtherFees || $otherFeesCount == 0)
			echo 'None<br>';
		else
	 		echo '', $messFee, '<br>';

		echo '<br><br>';
		echo 'Electricity Fee:'," ";

		if(!$getOtherFees || $otherFeesCount == 0)
			echo 'None<br>';
		else
	 		echo '', $electricityFee, '<br>';

		echo '<br><br>';

		if($otherFeesCount == 1 && $currentMonthFee == 'paid')
			echo '<b><span style="color:#2db300">You have no fee arrears</span></b>';
		else{
		if($currentMonthFee == "notpaid" || $previousMonthFee == "notpaid" )
				echo '<b><span style="color:red">You have fee arrears<br>Check Home Page for more details</span></b>';
		else
	 		echo '<b><span style="color:#2db300">You have no fee arrears</span></b>';
		 }

		echo '<br><br><br>';
	?>
	</div>

	

</body>
</html>