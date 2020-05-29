
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="welcome_style.css">
	<link rel="stylesheet" type="text/css" href="login_style.css">
	<script type="text/javascript">
		function validateForm(){
			var name = document.forms["loginForm"]["userName"].value;
			if (name == ""){
				alert("Username not entered");
				document.forms["loginForm"]["userName"].focus();
				return false;
			}

			var pass = document.forms["loginForm"]["password"].value;
			if (pass == ""){
				alert("Password not entered");
				document.forms["loginForm"]["password"].focus();
				return false;


			}
			
		}
	</script>

	
	<title>Login</title>
</head>
<body>
	

	<h1> Hostel Management System</h1>

	<?php

	$serverName = "localhost";
	$user = "root";
	$pass = "";


	$conn = mysqli_connect($serverName, $user, $pass);

	$db = "Hostel";

	

	if(!$conn){
		die("Connection failed: ");
	}

	

	$dbsql = "CREATE DATABASE IF NOT EXISTS Hostel";

	mysqli_query($conn, $dbsql);

	$connt = mysqli_connect($serverName, $user, $pass, $db);


    $adminSql = "CREATE TABLE IF NOT EXISTS Admin (

    Name VARCHAR(20),
    Password VARCHAR(20),
    Rent VARCHAR(4),
    UNIQUE (Name)
    )";

    mysqli_query($connt, $adminSql);
    	
  //  $insertAdmin = "DELETE FROM Admin";
   // mysqli_query($connt, $insertAdmin);
   
    $query = mysqli_query($connt, "SELECT * FROM Admin");
    if(mysqli_num_rows($query) == 0){
  	  $insertAdmin = "INSERT INTO Admin (Name, Password) VALUES('admin', '1234')";
		mysqli_query($connt,$insertAdmin);
	} 

    mysqli_close($conn);
    mysqli_close($connt);

    $incorrectPass = "";
    $correctPass = "";
    $uName = "";
    $passWord = "";


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
  		$uName = test_input($_POST["userName"]);
  		$passWord = test_input($_POST["password"]);
  		$incorrectPass = '<span style="color:red">Incorrect Username or Password</span';
   	 	$correctPass = "Correct Password";
	}

    function test_input($data) {
 	  $data = trim($data);
	  $data = stripslashes($data);
 	  $data = htmlspecialchars($data);
 	 return $data;
	}
	?>
	
 
 
<form name="loginForm"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validateForm()" method="POST">
	<center><table>
		<th colspan="2" align="center" style="color: #cccccc"><h2>Login</h2></th>
		<tr><td align="center">
			<?php
				$connt = mysqli_connect($serverName, $user, $pass, $db);
				$checkPass = "SELECT * FROM Admin WHERE BINARY Name = '$uName'AND BINARY Password = '$passWord'";
				$checkQuery = mysqli_query($connt, $checkPass);
				$checkStudentQuery = "SELECT S_ID FROM Students WHERE BINARY LastName = '$uName' AND BINARY Password = '$passWord'";
				 
				 	$checkStudent = mysqli_query($connt, $checkStudentQuery);
				 	if($checkStudent){
				 		$checkStudentExist = mysqli_num_rows($checkStudent);
				 		$array = mysqli_fetch_array($checkStudent);
				 	}else{
				 		$checkStudentExist = 0;
				 	}
				 	
				$checkQueryCount = mysqli_num_rows($checkQuery);

				if ($checkQueryCount == 0 && $checkStudentExist == 0 ){
					echo $incorrectPass;
				}elseif($checkStudentExist != 0){
					session_start();
					$_SESSION['loggedin'] = true;
					$_SESSION["user"] = $array['S_ID'];
					header("Location: StudentProfile.php");
				
				}else {
					session_start();
					$_SESSION['loggedin'] = true;
					$_SESSION["user"] = "admin";
					header("Location: home.php");
					
				}

  		 ?>
  		 	
  		 </td></tr>
		<tr><td align="center"><input type="text" name="userName" placeholder="Username"></td></tr>
		<tr><td align="center"><input type="password" name="password" placeholder="Password"></td></tr>
		<tr><td><br><br></td></tr>
		<tr><td colspan="2" align="center"><input type="submit" value="   Login   "></td>
		<tr><td><br><br></td></tr>
	</table>
</form>




</center>
	
	
</body>
</html>
