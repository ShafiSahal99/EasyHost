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
	<title>Home</title>
</head>
<body>
<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php" class="active">Home</a>
			<a href="NewRegistration.php">New Registration</a>
			<a href="Vacancy.php">Vacancy</a>
			<a href="Students.php">Students</a>
			<a href="Room.php">Room</a>
			<a href="Fees.php">Fees</a>
		</div>
	</div>

	<?php
		$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";

		$revenue = 0;
		$availableRevenue = 0;
		$balance = 0;

		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$getTotalStudentNumberQuery = "SELECT S_ID FROM Students";
		$getTotalStudentNumber = mysqli_query($conn, $getTotalStudentNumberQuery);
		if($getTotalStudentNumber)
			$totalStudentNumber = mysqli_num_rows($getTotalStudentNumber);

		$getTotalRoomCountQuery = "SELECT RoomNumber FROM Room";
		$getTotalRoomCount = mysqli_query($conn, $getTotalRoomCountQuery);
		if($getTotalRoomCount)
			$totalRoomCount = mysqli_num_rows($getTotalRoomCount);

		$getVacantRoomsQuery = "SELECT RoomNumber, Capacity-CurrentStatus FROM Room WHERE Capacity - CurrentStatus > 0";
		$getVacantRooms = mysqli_query($conn, $getVacantRoomsQuery);
		if($getVacantRooms)
			$vacantRoomCount = mysqli_num_rows($getVacantRooms);

		$availableSpaceCount = 0;

		if($getVacantRooms){
			while($availableSpaceArray = mysqli_fetch_array($getVacantRooms)){
					$availableSpaceCount += $availableSpaceArray['Capacity-CurrentStatus'];
				}
			}

		$getCautionArrearsQuery = "SELECT S_ID FROM Students WHERE Caution = 'notpaid'";
		$getCautionArrears = mysqli_query($conn, $getCautionArrearsQuery);
		if($getCautionArrears)
			$cautionArrearsCount = mysqli_num_rows($getCautionArrears);

		$getCurrentMonthFeeArrearsQuery = "SELECT S_ID FROM Students WHERE CurrentMonthFee = 'notpaid'";
		$getCurrentMonthFeeArrears = mysqli_query($conn, $getCurrentMonthFeeArrearsQuery);
		if($getCurrentMonthFeeArrears)
			$currentMonthFeeArrearsCount = mysqli_num_rows($getCurrentMonthFeeArrears);

		$getPreviousMonthFeeArrearsQuery = "SELECT S_ID FROM Students WHERE CurrentMonthFee = 'notpaid' AND PreviousMonthFee = 'notpaid'";
		$getPreviousMonthFeeArrears = mysqli_query($conn, $getPreviousMonthFeeArrearsQuery);
		if($getPreviousMonthFeeArrears)
			$previousMonthFeeArrearsCount = mysqli_num_rows($getPreviousMonthFeeArrears);

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

		$getCurrentMonthFeePaidStudentsQuery = "SELECT S_ID FROM Students WHERE CurrentMonthFee = 'paid'";
		$getCurrentMonthFeePaidStudents = mysqli_query($conn, $getCurrentMonthFeePaidStudentsQuery);
		if($getCurrentMonthFeePaidStudents){
			$currentMonthFeePaidStudentsCount = mysqli_num_rows($getCurrentMonthFeePaidStudents);
			$revenue = $rent * $currentMonthFeePaidStudentsCount;

		}

		if($getTotalStudentNumber){
			$availableRevenue = $totalStudentNumber * $rent;
			$balance = $availableRevenue - $revenue;
		}



	?>

	<br><br><br>
<div class="homePageStyle">
	<?php 
		echo '<br>';

		echo '<center><h2 style="color: #ff6600">Students</h2></center>';
	
		echo '<br><br>';
		echo 'Total Number of Students in Your Hostel:'," ";

		if(!$getTotalStudentNumber || $totalStudentNumber == 0)
			echo 'None<br>';
		else
	 		echo '', $totalStudentNumber, '<br>';

		echo '<br><br><br>';
	?>
</div>

<br><br><br><br><br>

<div class="homePageStyle">
	<?php
	echo '<br>';
	echo '<center><h2 style="color: #ff6600">Rooms</h2></center>';
	echo '<br><br>';

	 	echo 'Total Number of Rooms in Your Hostel:'," ";

		if(!$getTotalRoomCount || $totalRoomCount == 0)
			echo 'None<br>';
		else
			echo '', $totalRoomCount, '<br>';


		echo '<br><br>';

		echo 'Total Number of Vacant Rooms in Your Hostel:'," ";

		if(!$getVacantRooms || $vacantRoomCount == 0)
			echo 'None<br>';
		else
			echo '', $vacantRoomCount, '<br>';

		echo '<br><br>';

	 	echo 'Total Number of Vacant Spaces in Your Hostel:'," ";

		if(!$getVacantRooms || $vacantRoomCount == 0)
			echo 'None<br>';
		else
			echo '', $availableSpaceCount, '<br>';

		echo '<br><br>';
		?>
</div>

<br><br><br><br><br>

<div class="homePageStyle">
	<?php
		echo '<br><br>';

		echo '<center><h2 style="color: #ff6600">Fee arrears</h2></center>';
		echo '<br><br>';

	 	echo '<b>Students who did not paid the Caution Deposit:'," ";

		if(!$getCautionArrears || $cautionArrearsCount == 0)
			echo 'None<br>';
		else
			echo '', $cautionArrearsCount, '<br>';

		echo '<br><br>';

	 	echo 'Students who did not paid the Current Month Fee:'," ";

		if(!$getCurrentMonthFeeArrears || $currentMonthFeeArrearsCount == 0)
			echo 'None<br>';
		else
			echo '', $currentMonthFeeArrearsCount, '<br>';

		echo '<br><br>';

	 	echo 'Students who did not paid the Current Month Fee and Previous Month Fee:'," ";

		if(!$getPreviousMonthFeeArrears || $previousMonthFeeArrearsCount == 0)
			echo 'None<br>';
		else
			echo '', $previousMonthFeeArrearsCount, '';

		echo '<br><br><br>';

	?>
</div>
	
<br><br><br><br><br>

<div class="homePageStyle">
	<?php  

		echo '<br><br>';

		echo '<center><h2 style="color: #ff6600">Expenditures of this month</h2></center>';
		echo '<br><br>';


		echo '<b>Mess Fee:'," ";

		if(!$getOtherFees || $otherFeesCount == 0)
			echo 'None<br>';
		else
			echo '', $messFee, '<br>';

		echo '<br><br>';

		echo '<b>Electricity Fee:'," ";

		if(!$getOtherFees || $otherFeesCount == 0)
			echo 'None<br>';
		else
			echo '', $electricityFee, '<br>';

		echo '<br><br>';
	?>
</div>

<br><br><br><br><br>

<div class="homePageStyle">
	<?php
		echo '<br><br>';

		echo '<center><h2 style="color: #ff6600">Revenue earned this month</h2></center>';
		echo '<br><br>';


		echo '<b>Revenue:'," ";

		
		if(!$getRent || $RentCount == 0)
			echo 'None<br>';
		else
			echo '', $revenue, '<br>';
		

		echo '<br><br>';

		echo '<b>Total Available Revenue:'," ";

		
		if(!$getRent || $RentCount == 0)
			echo 'None<br>';
		else
			echo '', $availableRevenue, '<br>';
		

		echo '<br><br>';


		echo '<b> Revenue Due:'," ";

		
		if(!$getRent || $RentCount == 0)
			echo 'None<br>';
		else
			echo '', $balance, '<br>';
		

		echo '<br><br>';					
	?>
</div>
<br><br><br><br><br>

	<center>
		<input type="button" name="logout" class="normalButton" value="Log Out" onclick="window.location.href='logout.php'">
	</center>

	<br><br><br><br><br>

</body>
</html>
