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
	<title>Search Results</title>
</head>
<body>

	<h1>Hostel Management System</h1>

	<?php
	    $serverName = "localhost";
		$user = "root";
		$pass = "";
		$db = "Hostel";


		$conn = mysqli_connect($serverName, $user, $pass, $db);

		$firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
		$lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
		$dob = mysqli_real_escape_string($conn, $_POST['dob']);
		$mobileNumber = mysqli_real_escape_string($conn, $_POST['mobileNumber']);
		$houseName = mysqli_real_escape_string($conn, $_POST['houseName']);
		$district = mysqli_real_escape_string($conn, $_POST['district']);
		$joinDate = mysqli_real_escape_string($conn, $_POST['joinDate']);
		$roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);

		$searchStudentsQuery = "SELECT * FROM Students
							    WHERE FirstName = '$firstName' OR
							    	  LastName = '$lastName' OR
							    	  DOB = '$dob' OR
							    	  MobileNumber = '$mobileNumber' OR
							    	  HouseName = '$houseName' OR
							    	  District = '$district' OR
							    	  JoinDate = '$joinDate' OR
							    	  RoomNumber = '$roomNumber'";

		$searchStudent = mysqli_query($conn, $searchStudentsQuery);
		if($searchStudent)
			$searchStudentCount = mysqli_num_rows($searchStudent);

		if($searchStudentCount == 0){
			echo '<b><span style="color:red"><center>No matching result</center></span></b>';
			return;
		}
	?>

	<center><h2 style="color: #ff6600">Search Results</h2></center>	

<table cellspacing="0">
	<tbody class="dataTable">
	
	<tr><th>Student ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Mobile Number</th><th>Action</th></tr>
	
	<?php while ($array = mysqli_fetch_array($searchStudent)){ ?>	
	<tr><td><?php echo $array["S_ID"];?></td><td><?php echo $array["FirstName"];?></td><td><?php echo $array["LastName"];?></td><td><?php echo $array["DOB"]; ?></td><td><?php echo $array["MobileNumber"]; ?></td>  
	 <td>
	 	<form name="detailsForm" class="editDeleteForm" action="StudentDetails.php" method="POST">
	 		<input type="submit" name="details" class="tableSubmit" value="Details"/>
	 		<input type="hidden" name="s_id" value="<?php echo $array['S_ID'];?>">
	 		
	 	</form>

	 	<form name="detailsForm" class="editDeleteForm" action="Students.php" method="POST" onsubmit="return confirmPayFee()">
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
	<?php    } mysqli_free_result($searchStudent); ?>
</tbody>
</table>

</body>
</html>
