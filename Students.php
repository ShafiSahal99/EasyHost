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
			var conf = confirm('Confirm to Pay Fee. \nTo pay previous month fee goto Fees section.');

			if(!conf)
				return false;
		}
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Students</title>
</head>
<body>
	<?php $serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";


		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$refreshStatus = 0;
		$isStudentExistQuery = "SELECT * FROM Students";
		$isStudentExist = mysqli_query($conn, $isStudentExistQuery);
	?>

	<h1>Hostel Management System</h1>
	<div class="topnav">
		<div class="topnav-right">
			<a href="Home.php">Home</a>
			<a href="NewRegistration.php">New Registration</a>
			<a href="Vacancy.php">Vacancy</a>
			<a href="Students.php" class="active">Students</a>
			<a href="Room.php">Room</a>
			<a href="Fees.php">Fees</a>
		</div>
	</div>
	<br><br>

	<?php

		if(isset($_POST['payFee'])){
			$s_id = $_POST['s_id'];
			
			$payFeeQuery = "UPDATE Students SET CurrentMonthFee = 'paid' WHERE S_ID = '$s_id'";
			mysqli_query($conn, $payFeeQuery);

			echo '<b><span style="color:#2db300"><center>Payment entered</center></span></b>';

		}

		if(isset($_POST['deleteAll'])){
			$getAllRoomQuery = "SELECT RoomNumber FROM Students";
			$getAllRoom = mysqli_query($conn, $getAllRoomQuery);

			while($AllRoomArray = mysqli_fetch_array($getAllRoom)){
				$currentRoomNumber = $AllRoomArray['RoomNumber'];
				$deleteRoomQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = '$currentRoomNumber'";
				mysqli_query($conn, $deleteRoomQuery);
			}

			$deleteStudentQuery = "DROP TABLE Students";
			mysqli_query($conn, $deleteStudentQuery);

		}
	
		if(isset($_POST['delete'])){
			$s_id = $_POST['deleteStudent'];

			$getDeleteRoomNumberQuery = "SELECT RoomNumber FROM Students WHERE S_ID = '$s_id'";
			$getDeleteRoomNumber = mysqli_query($conn, $getDeleteRoomNumberQuery);
			$deleteRoomNumberArray = mysqli_fetch_array($getDeleteRoomNumber);
			$deleteRoomNumber = $deleteRoomNumberArray['RoomNumber'];
			$decrementCurrentStatusQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = '$deleteRoomNumber'";
			mysqli_query($conn, $decrementCurrentStatusQuery);

			$deleteStudent = "DELETE FROM Students WHERE S_ID = '$s_id'";
			mysqli_query($conn, $deleteStudent);

			echo '<b><span style="color:#2db300"><center>Student Deleted</center></span></b>';
		}

		if(isset($_POST['editStudent'])){
			$s_id = $_POST['s_id'];
			$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
			$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
			$dob = mysqli_real_escape_string($conn, $_POST['dob']);
			$houseName = mysqli_real_escape_string($conn, $_POST['houseName']);
			$district = mysqli_real_escape_string($conn, $_POST['district']);
			$pin = mysqli_real_escape_string($conn, $_POST['pin']);
			$joinDate = mysqli_real_escape_string($conn, $_POST['joinDate']);
			$caution = mysqli_real_escape_string($conn, $_POST['caution']);
			$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
			$guardianName = mysqli_real_escape_string($conn, $_POST['guardianName']);
			$guardianMobileNumber = mysqli_real_escape_string($conn, $_POST['guardianMobileNumber']);
			$roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);

			$isStudentDuplicateQuery = "SELECT * FROM Students WHERE DOB = '$dob' AND FirstName = '$firstName' AND LastName = '$lastName' AND MobileNumber = '$mobileNumber' AND S_ID <> '$s_id'";

    	    $isStudentDuplicate = mysqli_query($conn, $isStudentDuplicateQuery);
    	    $isStudentDuplicateArray = mysqli_fetch_assoc($isStudentDuplicate);
    	    $StudentDuplicateList = mysqli_num_rows($isStudentDuplicate);

    	    $isRoomExistQuery = "SELECT * FROM Room WHERE RoomNumber = $roomNumber";
    	    $isRoomExist = mysqli_query($conn, $isRoomExistQuery);
    	    $isRoomExistList = mysqli_num_rows($isRoomExist);

    	    $oldRoomQuery = "SELECT RoomNumber FROM Students WHERE S_ID = '$s_id'";
    	    	$oldRoom = mysqli_query($conn, $oldRoomQuery);
    	    	$oldRoomArray = mysqli_fetch_array($oldRoom);
    	    	$oldRoomNumber = $oldRoomArray['RoomNumber'];

    	    if($isRoomExistList == 0){
    	    	echo '<b><span style="color:red"><center>Given room does not Exist</center><center>Check Room for more Details</center></span></b>';
    	    }else{ 
    	    	if($StudentDuplicateList == 0){

    	    	if($oldRoomNumber != $roomNumber){

    	    	$getVacancyQuery = "SELECT Capacity-CurrentStatus FROM Room WHERE RoomNumber = $roomNumber";
    	    	$vacancy = mysqli_query($conn, $getVacancyQuery);
    	    	$vacancyArray = mysqli_fetch_array($vacancy);
    	    }else{
    	    	$vacancyArray["Capacity-CurrentStatus"] = "0";
    	    }

    	    	if($vacancyArray["Capacity-CurrentStatus"] == "0"){
    	    		echo '<b><span style="color:red"><center>Student not registered</center><center>No space available in given room</center><center>Check vacancy for available spaces</center></span></b>';
    	    	}else{

    	    	
    	    	$editStudentQuery = "UPDATE Students
								 SET FirstName = '$firstName',
							         LastName = '$lastName', 
								 	 DOB = '$dob',
								 	 HouseName = '$houseName',
								 	 District = '$district',
								 	 PIN = '$pin',
								 	 JoinDate = '$joinDate',
								 	 Caution = '$caution',
								 	 MobileNumber = '$mobileNumber',
								 	 GuardianName = '$guardianName',
								 	 GuardianMobileNumber = '$guardianMobileNumber',
								 	 RoomNumber = '$roomNumber',
								 	 Password = '$password'
								 WHERE S_ID = '$s_id'";
			$editStudent = mysqli_query($conn, $editStudentQuery);
			echo '<b><span style="color:#2db300"><center>Changes Saved</center></span></b>'; 

			$decrementCurrentStatusQuery = "UPDATE Room SET CurrentStatus = CurrentStatus - 1 WHERE RoomNumber = $oldRoomNumber";
    	    	mysqli_query($conn, $decrementCurrentStatusQuery);

			$incrementCurrentStatusQuery = "UPDATE Room SET CurrentStatus = CurrentStatus + 1 WHERE RoomNumber = $roomNumber";
			mysqli_query($conn, $incrementCurrentStatusQuery);
			

    	    	}
    	    }else{
    	    	echo '<b><span style="color:red"><center>Student duplicate found</center><center>Check Student details for more</center></span></b>'; 
    	    }
    	   
    }

			

			
		}


		if(isset($_POST['register'])){
			$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
			$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
			$dob = mysqli_real_escape_string($conn, $_POST['dob']);
			$houseName = mysqli_real_escape_string($conn, $_POST['houseName']);
			$district = mysqli_real_escape_string($conn, $_POST['district']);
			$pin = mysqli_real_escape_string($conn, $_POST['pin']);
			$joinDate = mysqli_real_escape_string($conn, $_POST['joinDate']);
			$caution = mysqli_real_escape_string($conn, $_POST['caution']);
			$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
			$guardianName = mysqli_real_escape_string($conn, $_POST['guardianName']);
			$guardianMobileNumber = mysqli_real_escape_string($conn, $_POST['guardianMobileNumber']);
			$roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);
			$password = mysqli_real_escape_string($conn, $_POST['password']);
		
			$createStudentsQuery = "CREATE TABLE IF NOT EXISTS Students (

				S_ID INT(6) NOT NULL AUTO_INCREMENT,
				FirstName VARCHAR(20),
				LastName VARCHAR(20),
				DOB DATE,
				HouseName VARCHAR(20),
				District VARCHAR(20),
				PIN VARCHAR(7),
				JoinDate DATE,
				Caution VARCHAR(10),
				MobileNumber VARCHAR(50),
				GuardianName VARCHAR(20),
				GuardianMobileNumber VARCHAR(50),
				RoomNumber VARCHAR(3),
				Password VARCHAR(20),
				CurrentMonthFee VARCHAR(10),
				PreviousMonthFee VARCHAR(10),
				PRIMARY KEY (S_ID)

    	    )";

    	    mysqli_query($conn, $createStudentsQuery);

    	    
    	    

    	    $isStudentDuplicateQuery = "SELECT * FROM Students WHERE DOB = '$dob' AND FirstName = '$firstName' AND LastName = '$lastName' AND MobileNumber = '$mobileNumber'";

    	    $isStudentDuplicate = mysqli_query($conn, $isStudentDuplicateQuery);
    	    $isStudentDuplicateArray = mysqli_fetch_assoc($isStudentDuplicate);
    	    $StudentDuplicateList = mysqli_num_rows($isStudentDuplicate);

    	    $isRoomExistQuery = "SELECT * FROM Room WHERE RoomNumber = $roomNumber";
    	    $isRoomExist = mysqli_query($conn, $isRoomExistQuery);
    	    if($isRoomExist)
    	    	$isRoomExistList = mysqli_num_rows($isRoomExist);
    	    else
    	    	$isRoomExistList = 0;

    	    if($isRoomExistList == 0){
    	    	echo '<b><span style="color:red"><center>Given room does not Exist</center><center>Check Room for more Details</center><center>You can use Auto Fill after registartion to set room automatically</center></span></b>';
    	    }
    	    
    	    if($StudentDuplicateList == 0){
    	    	$getVacancyQuery = "SELECT Capacity-CurrentStatus FROM Room WHERE RoomNumber = $roomNumber";
    	    	$vacancy = mysqli_query($conn, $getVacancyQuery);
    	    	if($vacancy)
    	    		$vacancyArray = mysqli_fetch_array($vacancy);
    	    	else
    	    		$vacancyArray["Capacity-CurrentStatus"] = 0;

    	    	if($vacancyArray["Capacity-CurrentStatus"] == "0"){
    	    		echo '<b><span style="color:red"><center>No space available in given room</center><br><center>Check vacancy for available spaces</center></span></b>';
    	    			
    	    	}else{

    	    	$insertStudentsQuery = "INSERT INTO Students (FirstName, LastName, DOB, HouseName, District, PIN, JoinDate, Caution, MobileNumber, GuardianName, GuardianMobileNumber, RoomNumber, Password, CurrentMonthFee, PreviousMonthFee)
    	    	 VALUES ('$firstName', '$lastName', '$dob', '$houseName', '$district', '$pin', '$joinDate', '$caution', '$mobileNumber','$guardianName', '$guardianMobileNumber', '$roomNumber', '$password', 'notpaid', 'notpaid')";

    	    mysqli_query($conn, $insertStudentsQuery);

    	    $updateRoomQuery = "UPDATE Room SET CurrentStatus = CurrentStatus + 1 WHERE RoomNumber = $roomNumber";
    	    mysqli_query($conn, $updateRoomQuery);

    	    echo '<b><span style="color:#2db300""><center>Student registered</center></span></b>';
    	}
    		
    	    	
    	    }else{
    	    	echo '<b><span style="color:red"><center>Student already registered</center></span></b>';
    	}
    
    	    
		
	}

		$isStudentExistQuery = "SELECT * FROM Students";
		$isStudentExist = mysqli_query($conn, $isStudentExistQuery);

		if(!$isStudentExist)
			$studentExistList = 0;
		else
			$studentExistList = mysqli_num_rows($isStudentExist);

		if(!$isStudentExist || $studentExistList == 0){
			echo '<b><span style="color:red"><center>No Student Registered</center><br></span></b>';
			return;
		}else{

		echo '<br><center><form action="Search.php" name="deleteAllForm" class="editDeleteForm" method="POST" >
									<input type="submit" name="search" class="normalButtonSubmit"value="  Search  ">
									</form>', " ";

	
		echo '<form action="Students.php" name="deleteAllForm" class="editDeleteForm" onsubmit="return confirmDeleteAll()" method="POST" >
									<input type="submit" name="deleteAll" class="normalButtonSubmit"value="Delete All">
									</center></form>';

	
			
		}

	?>

<center><h2 style="color: #ff6600">Students List</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Mobile Number</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($isStudentExist)){ ?>	
	<tr><td><?php echo $array["S_ID"];?></td><td><?php echo $array["FirstName"];?></td><td><?php echo $array["LastName"];?></td><td><?php echo $array["DOB"]; ?></td><td><?php echo $array["MobileNumber"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentDetails.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form name="detailsForm" class="editDeleteForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" onsubmit="return confirmPayFee()">
	 		<input type="submit" name="payFee" class="tableSubmit" value="Pay Fee"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form  name="editForm" class="editDeleteForm" action="EditStudent.php" method="POST">
	 		<input type="submit" name="edit" class="tableSubmit" value="Edit"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 	</form>

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return confirmDelete()">
	 		<input type="submit" name="delete" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteStudent" value="<?php echo $array['S_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($isStudentExist); ?>
</tbody>
</table>

</body>
</html>
