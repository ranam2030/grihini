<?php
	
	$con = mysqli_connect('localhost','root','','grihini');
	$errors = array();


		if(isset($_POST['adminLogBtn']))
		{
			$uname = mysqli_real_escape_string($con, $_POST['uname']);
			$pass = mysqli_real_escape_string($con, $_POST['pass']);

			$query = "SELECT * FROM admin WHERE user_name = '$uname' AND user_password = '$pass' ";

			$result = mysqli_query($con, $query);

			if(mysqli_num_rows($result) == 1)
			{
				echo "<script>window.location.assign('adminPage.php?status=loginSuccess')</script>";		}
			else
			{
				array_push($errors, "Email or Password is incorrect");
			}
		}


		if(isset($_POST['edtButton']))
		{
			// $item_id = $_POST['item_id'];
			// header("Location: editItem.php?item_id=$item_id");

		}


		if(isset($_POST['rmvButton']))
		{
			$item_id = $_POST['item_id'];
			$q1 = "DELETE FROM orders_food_menu WHERE item_id='$item_id'";
			$q2 = "DELETE FROM food_menu WHERE item_id='$item_id'";

			mysqli_query($con,$q1);
			mysqli_query($con,$q2);

			echo "<script>window.location.assign('foodMenu.php')</script>";
		}

?>
