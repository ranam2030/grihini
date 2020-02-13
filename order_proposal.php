<?php
	session_start();

    if(isset($_GET['logout']))
	{
		session_destroy();
		unset($_SESSION['user_name']);
		header("location: index.php");
	}

	$con = mysqli_connect('localhost','root','','grihini');
	$query = "SELECT * FROM orders WHERE order_status='Pending' ORDER BY order_id";
	$result = mysqli_query($con,$query);


	if(isset($_SESSION['order_cart']))
	{
			$cartCount = count($_SESSION['order_cart']);

	}
	else
	{
		$cartCount = 0;
	}

    if(!empty($_SESSION['order_cart']))
    {
        $total = 0;
        foreach ($_SESSION['order_cart'] as $keys => $values)
        {
            $total = $total + ($values['item_quantity'] * $values['item_price']);
            $_SESSION['total_cost'] = $total;
        }
    }

    $cook_name = $_SESSION['user_name'];
    $q1 = "SELECT * FROM notifications WHERE cook_user_name='$cook_name' AND user='cook'";
    $q2 = "SELECT * FROM notifications WHERE cook_user_name='$cook_name' AND user='cook' AND read_n=1";
    $data = mysqli_query($con,$q1);
    $new_data = mysqli_query($con,$q2);
    $count = mysqli_num_rows($new_data);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>Order Proposal</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/order_proposal.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <!-- Preloader Starts -->
    
    <!-- Preloader End -->

    <!-- Header Area Starts -->
	<header class="header-area header-area2">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo-area">
                        <a href="cookHome.php"><img src="assets/images/logo/grihini.png" alt="logo"></a>
                    </div>
                </div>
                <div class="col-lg-10">
                    <div class="custom-navbar">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>  
                    <div class="main-menu main-menu2">
                        <ul>
                            <li class="active"><a href="cookHome.php">home</a></li>
                            <li><a href="cookAbout.php">about</a></li>
                            <li><a href="order_proposal.php">Order Proposals</a></li>
                            <li><a href="cookMenu.php">menu</a></li>
                            <li><a href="cookContact-us.php">contact</a></li>
                            <li>
                                <?php if (isset($_SESSION['user_name'])) {?>
                                    <a id="user-name" href="#"> <strong style="color:green;"><?php echo $_SESSION['user_name']; ?></strong>  <i class="fas fa-user-circle"></i> </a>
                                    <ul class="sub-menu">
                                        <li><a href="#">My Profile</a></li>
                                        <li><a href="index.php?logout='1'">Logout</a></li>
                                    </ul>
                                <?php }else{ ?>
                                    <a href="login.php">login / register</a>
                                    <ul class="sub-menu">
                                        <li><a href="login.php">Customer</a></li>
                                        <li><a href="cook_login.php">Cook</a></li>
                                    </ul>
                                    <?php }?>
                            </li>

                            <li class="dropdown">       
                                
                                <button class="dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 5px;">
                                <i class="far fa-bell"></i><?php 
                                if($count > 0)
                                {   
                                    echo "(".$count.")";
                                }; ?>
                                </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width: 350px;">
                                    <?php
                                        foreach ($data as $value) {
                                    ?>

                                    <?php
                                        if($value['read_n']=='1'){
                                    ?>  <ul>
                                            <li style="font-weight: bold;"><?php echo $value['consumer_user_name'].' '.$value['notification_details']; ?></li>
                                        </ul>
                                    <?php       
                                        }
                                        else
                                        {
                                    ?>
                                            <ul>
                                                <li><?php echo $value['consumer_user_name'].' '.$value['notification_details']; ?>
                                                </li>
                                            </ul>

                                    <?php
                                        }
                                        }
                                    ?>
                                  </div>
                                
                             </li>

                            <li><a href="cookCart.php"><i class="fas fa-cart-plus"></i> My Cart(<?php echo $cartCount; ?>) - ৳ <?php 
                                if(isset($_SESSION['total_cost']))
                                {
                                    echo number_format($_SESSION['total_cost'], 2);
                                }
                                else
                                {
                                    echo number_format(0,2);
                                }
                                 ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    <!-- Banner Area Starts -->
    <section class="banner-area banner-area2 menu-bg text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1><i>Order Proposals</i></h1>
                    <p class="pt-2"><i>check out your favorite food from our menu</i></p>
                </div>
            </div>
        </div>
    </section>

	<?php
				while($rows = mysqli_fetch_assoc($result))
				{
			?>		
					<div class="contain">
						<div class="content">
							<h2 style="text-align: center;border: 1px dashed black;width: 400px;margin: 0 auto; color: black;">Order No:<?php echo $rows['order_id']; ?></h2>
                            <br>
							<span style="display: inline-block; margin-left: 25px;"><h6 style="color: black; font-style: italic;">Order: <?php echo $rows['order_time'].'</br>Order:'.$rows['order_date']; ?></h6></span>
							<span style="display: inline-block;margin-left: 265px;">
								<h6 style="color: black; font-style: italic;">Delivary: <?php echo $rows['delivery_time'].'</br>Delivary:'.$rows['delivery_date']; ?></h6>
							</span>
							<br>

							Order By: <a style="font-size: 20px;text-decoration: none;" href="showProfile.php?uname=<?php echo $rows['consumer_user_name']; ?>"><?php echo $rows['consumer_user_name']; ?></a>
							
							<table style="border: 1px dashed black;">
								<h3 style="text-align: center;">Order Details</h3>
								<tr>
									<th width="20%" style="text-align: center;">Item Id</th>
									<th width="20%" style="text-align: center;">Item Name</th>
									<th width="10%" style="text-align: center;">Quantity</th>
									<th width="20%" style="text-align: center;">Sub-Total</th>
								</tr>
								<?php
									$order_id = $rows['order_id'];
									$total = 0;

									$state = "SELECT t1.item_id,t2.item_name,t1.quantity,t1.price FROM orders_food_menu AS t1 JOIN food_menu AS t2 ON t1.item_id = t2.item_id WHERE t1.order_id='$order_id'";
									$run = mysqli_query($con,$state);

									while($items = mysqli_fetch_assoc($run))
									{
								?>
										<tr>
											<td style="text-align: center;"><?php echo $items['item_id'] ?></td>
											<td style="text-align: center;"><?php echo $items['item_name'] ?></td>
											<td style="text-align: center;"><?php echo $items['quantity'] ?></td>
											<td style="text-align: center;"><?php echo $items['price'] ?></td>
										</tr>

								<?php
									}
								?>
								
							</table>

							<form method="post" action="interested.php">
								<input type="hidden" name="order_id" value="<?php echo $rows['order_id']; ?>">
								<input type="hidden" name="cook_name" value="<?php echo $_SESSION['user_name']; ?>">
								<input type="hidden" name="consumer_name" value="<?php echo $rows['consumer_user_name']; ?>">
								<button type="submit" class="template-btn mt-3" style="background-color: orange; margin-left: 540px; border-radius: 5px;" name="interestedBtn">Interest</button>
							</form>
							<br>

						</div>
					</div>
			
		<?php  } ?>		


        <!-- Javascript -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <script src="assets/js/vendor/owl-carousel.min.js"></script>
    <script src="assets/js/vendor/jquery.datetimepicker.full.min.js"></script>
    <script src="assets/js/vendor/jquery.nice-select.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

</body>
</html>