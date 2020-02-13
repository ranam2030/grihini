<?php
	session_start();


	$con = mysqli_connect('localhost','root','','grihini');
	$errors = array();

	if(isset($_POST['cookSignBtn']))
	{
		$email = mysqli_real_escape_string($con, $_POST['cookSignEmail']);
		$array = explode("@", $email);
		$uname = $array['0'];
		$pass = mysqli_real_escape_string($con, $_POST['cookSignPass_1']);
		$confPass = mysqli_real_escape_string($con, $_POST['cookSignPass_2']);
		$phnNo = mysqli_real_escape_string($con, $_POST['cookphnNo']);

		$statement = "SELECT * FROM cook WHERE email = '$email' OR phn_no = '$phnNo' ";


		$result = mysqli_query($con, $statement);

		$user = mysqli_fetch_assoc($result);


		if($user)
		{
			if($user['user_name'] === $uname)
			{
				array_push($errors, "Username already exists");

			}
			
			if($user['email'] === $email)
			{
				array_push($errors, "Email already exists");
			}
		}

		if($pass != $confPass)
		{
			array_push($errors, "The two passwords don't match");
		}
		
		if(count($errors) == 0)
		{
			$password = md5($pass);
			$insertQuery = "INSERT INTO cook(user_name,user_password,email,phn_no) VALUES ('$uname','$password','$email','$phnNo')";
			mysqli_query($con, $insertQuery);
			$_SESSION['user_name'] = $uname;

			echo "<script>window.location.assign('cook_login.php?status=signupSuccess')</script>";		
		}
	}


	if(isset($_POST['cookLogBtn']))
	{
		$email = mysqli_real_escape_string($con, $_POST['cookLogEmail']);
		$pass = mysqli_real_escape_string($con, $_POST['cookLogPass']);

		$password = md5($pass);
		$query = "SELECT * FROM cook WHERE email = '$email' AND user_password = '$password' ";

		$result = mysqli_query($con, $query);

		if(mysqli_num_rows($result) == 1)
		{
			$array = explode("@", $email);
			$uname = $array['0'];
			$_SESSION['user_name'] = $uname;

			echo "<script>window.location.assign('cookHome.php?status=loginSuccess')</script>";		}
		else
		{
			array_push($errors, "Email or Password is incorrect");
		}
	}

	if(isset($_POST['cookUpBtn']))
	{
		$first_name = mysqli_real_escape_string($con, $_POST['cookUpFirstName']);
		$last_name = mysqli_real_escape_string($con, $_POST['cookUpLastName']);
		$email = mysqli_real_escape_string($con, $_POST['cookUpEmail']);
		$address = mysqli_real_escape_string($con, $_POST['cookUpAddress']);
		$phnNo = mysqli_real_escape_string($con, $_POST['phnNo']);
		$dob = mysqli_real_escape_string($con, $_POST['dob']);
		$details = mysqli_real_escape_string($con, $_POST['cookUpDetails']);
		$array = explode("@", $email);
		$uname = $array['0'];

		
		$userUpdate = "UPDATE `cook` SET `user_name`='".$uname."',`first_name`='".$first_name."',`last_name`='".$last_name."',`email`='".$email."',`phn_no`='".$phnNo."',`address`='".$address."',`dob`='".$dob."',`details`='".$details."' WHERE `user_name`='".$_SESSION['user_name']."'";

		mysqli_query($con, $userUpdate);

		echo "<script>window.location.assign('cookProfile.php?status=updateSuccess')</script>";
	}



	if(isset($_POST['cartButton']))
	{
		if(isset($_SESSION['order_cart']))
		{
			$item_array_id = array_column($_SESSION['order_cart'], "item_id");
			if(!in_array($_POST['item_id'], $item_array_id))
			{
				$count = count($_SESSION['order_cart']);
				$item_array = array('item_id' => $_POST['item_id'],
									'item_name' => $_POST['item_name'], 
									'item_price' => $_POST['item_price'], 
									'item_quantity' => $_POST['quantity'] 
									);
				$_SESSION['order_cart'][$count] = $item_array;
				echo "<script>alert('Item is Added!')</script>";
				echo "<script>window.location.assign('menu.php')</script>";
			}
			else
			{
				echo "<script>alert('Item Already Added!')</script>";
				echo "<script>window.location.assign('menu.php')</script>";
			}
		}
		else
		{
			$item_array = array('item_id' => $_POST['item_id'],
								'item_name' => $_POST['item_name'], 
								'item_price' => $_POST['item_price'], 
								'item_quantity' => $_POST['quantity'] 
								);
			$_SESSION['order_cart'][0] = $item_array;
            echo "<script>alert('Item is Added!')</script>";
			echo "<script>window.location.assign('menu.php')</script>";
		}
	}


	if(isset($_GET['action']))
	{
		if($_GET['action'] == 'delete')
		{
			foreach ($_SESSION['order_cart'] as $keys => $values)
			{
				if($values['item_id'] == $_GET['id'])
				{
					unset($_SESSION['order_cart'][$keys]);
					echo "<script>window.location.assign('cart.php')</script>";
                    $_SESSION['total_cost'] =$_SESSION['total_cost'] - ($_GET['cost']*$_GET['quantity']);
				}
			}
		}
	}


	if(isset($_GET['notf']) && isset($_GET['uname']) && isset($_GET['order_id']))
	{
		$n_id = $_GET['notf'];
		$order_id = $_GET['order_id'];

		$q3 = "UPDATE notifications SET read_n = 0 WHERE notification_id='$n_id'";
		mysqli_query($con,$q3);

			$uname = $_GET['uname'];

			$query = "SELECT * FROM cook WHERE user_name = '$uname'";
			$records = mysqli_query($con,$query);
			$cnt = mysqli_num_rows($records);

			if($cnt == 1)
			{
				$field = mysqli_fetch_assoc($records);

				$_SESSION['cook_user_name'] = $field['user_name'];
				$_SESSION['cook_first_name'] = $field['first_name'];
				$_SESSION['cook_last_name'] = $field['last_name'];
				$_SESSION['cook_email'] = $field['email'];
				$_SESSION['cook_phn_no'] = $field['phn_no'];
				$_SESSION['cook_address'] = $field['address'];
				$_SESSION['cook_rating'] = $field['rating'];
			}

			header("Location: showCookProfile.php?notf=$n_id&uname=$uname&order_id=$order_id");
	}


	
?>