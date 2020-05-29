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
			var conf = confirm('Confirm to Pay Fee\nTo pay previous month fee goto Fees section.');

			if(!conf)
				return false;
		}
	</script>
	<link rel="stylesheet" type="text/css" href="main_style.css">
	<title>Students in Room</title>
</head>
<body>

	<?php
	$serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";
		$conn = mysqli_connect($serverName, $user, $pass, $db);
		
		if(isset($_POST['payFee'])){
			$s_id = $_POST['s_id'];
			
			$payFeeQuery = "UPDATE Students SET CurrentMonthFee = 'paid' WHERE S_ID = '$s_id'";
			mysqli_query($conn, $payFeeQuery);

			echo '<b><span style="color:#2db300"><center>Payment entered</center></span></b>';

		}

		if(isset($_POST['details'])){
		$roomNumber = $_POST['detailsRoomNumber'];

	?>

	<h1>Hostel Management System</h1>

	<?php
		

		$getStudentsInRoomQuery = "SELECT S_ID,FirstName, LastName, DOB, MobileNumber
								   FROM Students 
								   WHERE RoomNumber = '$roomNumber'";

		$getStudents = mysqli_query($conn, $getStudentsInRoomQuery);
		$studentList = mysqli_num_rows($getStudents);
	


		if($studentList == 0){
			echo '<b><span style="color:red"><center>No student present</center></span></b>';
		?>
			<center><h2 style="color: #ff6600">Students in Room <?php echo " ".$roomNumber; ?></h2></center>
		<?php
		}else{
			echo '<center><form action="Room.php" name="deleteAllForm" class="editDeleteForm" onsubmit="return confirmDeleteAll()" method="POST" >
									<input type="submit" name="deleteAllStudentsInRoom" class="normalButtonSubmit"value="Delete All">
									<input  type="hidden" name="deleteAllRoomNumber" value = "'.$roomNumber.'"
									</center></form>';
		?>

	<center><h2 style="color: #ff6600">Students in Room <?php echo " ".$roomNumber; ?></h2></center>
	
	<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Mobile Number</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($getStudents)){ ?>	
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

	 	<form method="POST" name="deleteForm" class="editDeleteForm" action="Room.php" onsubmit="return confirmDelete()">
	 		<input type="submit" name="deleteStudentInRoom" class="tableSubmit" value="Delete"/>
	 		<input type="hidden" name="deleteStudent" value="<?php echo $array['S_ID'];?>">
	 	</form>
	 </td>	
   </tr>
	<?php    } mysqli_free_result($getStudents); ?>
</tbody>
</table>
	<?php	} }  ?>
	
</body>
</html>
