<?php 
	session_start();

	$con = mysqli_connect('localhost','root','','grihini');


	if(isset($_GET['order_id']))
	{
		$cook = $_SESSION['cook_user_name'];
		$consumer_name = $_SESSION['user_name'];
		$order_id = $_GET['order_id'];
		$notif_details = 'confirmed you as cook,order: '.$order_id;
		$user = 'cook';

		$q1 = "UPDATE orders SET cook_user_name='$cook',order_status='Processing' WHERE order_id = '$order_id'";
		$q2 = "INSERT INTO notifications(order_id,consumer_user_name,cook_user_name,notification_details,user) VALUES ('$order_id','$consumer_name','$cook','$notif_details','$user')";
		mysqli_query($con,$q1);
		mysqli_query($con,$q2);


		echo "<script>window.location.assign('showCookProfile.php')</script>";
	}	
?>