<?php
if(isset($_POST["txtfirstname"]))
{

//Accept HTML Form data
$STUDENT_ID = $_POST["txtadmissionnumber"];
$FIRST_NAME = $_POST["txtfirstname"];
$LAST_NAME = $_POST["txtlastname"];
$ADDRESS = $_POST["txtaddress"];
$DOB = $_POST["birthdate"];
$EMAIL = $_POST["email"];
$GUADIAN_NAME = $_POST["txtguardianname"];
$GUADIAN_CONTACTNO = $_POST["txtcontactno"];
$PASSWORD = $_POST["txtpassword"];
$CONFIRM_PASSWORD = $_POST["txtconfirmpassword"];



//validate fields
	if (empty($FIRST_NAME) || empty($LAST_NAME) || empty($ADDRESS) || empty($DOB) || empty($EMAIL) || empty($GUADIAN_NAME) || empty($GUADIAN_CONTACTNO) || empty($PASSWORD) || empty($CONFIRM_PASSWORD))
 	{
        echo "<script>alert('All fields are required.');</script>";
  	}
  	else if ($PASSWORD != $CONFIRM_PASSWORD) 
  	{
        echo "<script>alert('Password and Confirm Password do not match.Please enter again.');</script>";
    } 
	else 
	{
		// Concatenate first name and last name
		$FULL_NAME = $FIRST_NAME . ' ' . $LAST_NAME;

		//Create a connection with MySQL Server
		$con = mysqli_connect("localhost","DSEUSER","dse456");

		//Select Database
		mysqli_select_db($con, "student_registration");

		// Check if email already exists
        $email_check_query = "SELECT * FROM tblstudent WHERE StudentEmail='$EMAIL' LIMIT 1";
        $email_result = mysqli_query($con, $email_check_query);
        $email_user = mysqli_fetch_assoc($email_result);

        // Check if admission number already exists
        $admission_check_query = "SELECT * FROM tblstudent WHERE StudentId='$STUDENT_ID' LIMIT 1";
        $admission_result = mysqli_query($con, $admission_check_query);
        $admission_user = mysqli_fetch_assoc($admission_result);

        if ($email_user) { 
            echo "<script>alert('Email already exists. Please use a different email.');</script>";
        } 
        elseif ($admission_user) {
            echo "<script>alert('Incorrect Admission number.Please check & try again');</script>";
        }
        else {
			//Perform SQLOperations
			$sql = "INSERT INTO tblstudent(StudentId,StudentFullName,StudentAddress,DOB,GuadianName,GuadianContactNo,StudentEmail,StudentPassword) VALUES ('$STUDENT_ID','$FULL_NAME','$ADDRESS','$DOB','$GUADIAN_NAME',$GUADIAN_CONTACTNO,'$EMAIL','$PASSWORD')";

			$result = mysqli_query($con, $sql);

			if ($result) {
            	echo "<script>alert('Successful Registration.');</script>";
        	} else {
            	echo "<script>alert('Error: " . $sql . "<br>" . mysqli_error($con) . "');</script>";
        	}
    	}

		//disconnect
		mysqli_close($con);
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Student Registration</title>
	<link rel="StyleSheet" href="StyleSheet.css">
</head>
<body>
	<div class="Container">
		<form name="stdRegistration" action="#" method="post">
			<h2>Student Registration</h2>
			<div class="content">
				<div class="input-box">
					<label for="firstname">First Name : </label>
					<input type="text" name="txtfirstname" required>
				</div>
				<div class="input-box">
					<label for="lastname">Last Name : </label>
					<input type="text" name="txtlastname" required>
				</div>
				<div class="input-box">
					<label for="address">Address : </label>
					<input type="text" name="txtaddress" required>
				</div>
				<div class="input-box">
					<label for="birthdate">Date of Birth : </label>
					<input type="Date" name="birthdate" required>
				</div>
				<div class="input-box">
					<label for="email">E-mail : </label>
					<input type="email" name="email" required>
				</div>
				<div class="input-box">
					<label for="admissionnumber">Admission Number : </label>
					<input type="text" name="txtadmissionnumber" required>
				</div>
				<div class="input-box">
					<label for="guardianname">Guardian Name : </label>
					<input type="text" name="txtguardianname" required>
				</div>
				<div class="input-box">
					<label for="contactno">Guardian Contact No : </label>
					<input type="tel" name="txtcontactno" required>
				</div>
				<div class="input-box">
					<label for="password">Password : </label>
					<input type="password" name="txtpassword" placeholder="Enter new password" required>
				</div>
				<div class="input-box">
					<label for="confirmpassword">Confirm Password : </label>
					<input type="password" name="txtconfirmpassword" placeholder="Confirm your password" required>
				</div>
				<div class="grade-select-container">
  					<label for="gradeSelect" class="grade-select-label">Grade:</label>
  					<select id="gradeSelect" class="grade-select-dropdown">
    					<option value="6">Grade 6</option>
    					<option value="7">Grade 7</option>
    					<option value="8">Grade 8</option>
    					<option value="9">Grade 9</option>
    					<option value="10">Grade 10</option>
    					<option value="11">Grade 11</option>
  					</select>
				</div>
			</div>
			<div class="checkbox">
  				<label><input type="checkbox" value="terms&privacypolicy" required>I Agree to <a href="#">Terms</a> & <a href="#">Privacy Policy</a>.</label>
			</div>
			<div class="button-container">
				<button type="submit" id="btnsubmit">Register</button>
			</div>
			
		</form>
	</div>

</body>
</html>