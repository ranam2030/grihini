<?php
	session_start();
	date_default_timezone_set('Asia/Dhaka');

	$con = mysqli_connect('localhost','root','','grihini');

	if(isset($_POST['checkButton']))
	{
		$uname = $_SESSION['user_name'];
		$order_date = date("Y-m-d");
		$order_time = date("h:i:s");
		$delivery_date = $_POST['delivary_date'];
		$delivery_time = $_POST['delivary_time'];

		$query = "INSERT INTO orders(consumer_user_name,order_date,order_time,delivery_date,delivery_time,order_status) VALUES('$uname','$order_date','$order_time','$delivery_date','$delivery_time','Pending')";
		mysqli_query($con,$query);
		$order_id = mysqli_insert_id($con);


		foreach ($_SESSION['order_cart'] as $keys => $values)
		{
			$item_id = $values['item_id'];
			$quantity = $values['item_quantity'];
			$price = number_format($values['item_quantity'] * $values['item_price'], 2);

			$query = "INSERT INTO orders_food_menu(order_id,item_id,quantity,price) VALUES('$order_id','$item_id','$quantity','$price')";
			mysqli_query($con,$query);
		}

		unset($_SESSION['order_cart']);
		echo "<script>window.location.assign('cart.php?status=orderSuccess')</script>";
	}

	
?>