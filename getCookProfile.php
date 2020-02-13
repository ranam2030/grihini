<?php

	$con = mysqli_connect('localhost','root','','grihini');

	$uname = $_SESSION['user_name'];
	$query = "SELECT * FROM cook WHERE user_name = '$uname'";
	$records = mysqli_query($con,$query);
	$count = mysqli_num_rows($records);

	if($count == 1)
	{
		$field = mysqli_fetch_array($records);

		$_SESSION['user_name'] = $field['user_name'];
		$_SESSION['first_name'] = $field['first_name'];
		$_SESSION['last_name'] = $field['last_name'];
		$_SESSION['email'] = $field['email'];
		$_SESSION['phn_no'] = $field['phn_no'];
		$_SESSION['dob'] = $field['dob'];
		$_SESSION['address'] = $field['address'];
		$_SESSION['rating'] = $field['rating'];
		$_SESSION['details'] = $field['details'];
	}
?>