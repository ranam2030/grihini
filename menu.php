<?php
	session_start();

    if(isset($_GET['logout']))
	{
		session_destroy();
		unset($_SESSION['user_name']);
		header("location: index.php");
	}

	$con = mysqli_connect('localhost','root','','grihini');
	$query = "SELECT * FROM food_menu ORDER BY item_id";
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

    if(isset($_SESSION['user_name']))
    {
        $consumer_name = $_SESSION['user_name'];
         $q1 = "SELECT * FROM notifications WHERE consumer_user_name='$consumer_name' AND user='consumer'";
        $q2 = "SELECT * FROM notifications WHERE consumer_user_name='$consumer_name' AND user='consumer' AND read_n=1";
        $data = mysqli_query($con,$q1);
        $new_data = mysqli_query($con,$q2);
        $count = mysqli_num_rows($new_data);
    }
    else
    {
        $count = 0;
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Page Title -->
    <title>Menu</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/jquery.datetimepicker.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <!-- Preloader Starts -->
    <div class="preloader">
        <div class="spinner"></div>
    </div>
    <!-- Preloader End -->

    <!-- Header Area Starts -->
	<header class="header-area header-area2">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="logo-area">
                        <a href="index.php"><img src="assets/images/logo/grihini.png" alt="logo"></a>
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
                            <li class="active"><a href="index.php">home</a></li>
                            <li><a href="about.php">about</a></li>
                            <li><a href="menu.php">menu</a></li>
                            <li><a href="contact-us.php">contact</a></li>
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
                                            <li style="font-weight: bold;"><?php echo $value['cook_user_name'].' '.$value['notification_details']; ?></li>
                                        </ul>
                                    <?php       
                                        }
                                        else
                                        {
                                    ?>
                                            <ul>
                                                <li><?php echo $value['cook_user_name'].' '.$value['notification_details']; ?>
                                                </li>
                                            </ul>

                                    <?php
                                        }
                                        }
                                    ?>
                                  </div>
                                
                             </li>

                            <li><a href="cart.php"><i class="fas fa-cart-plus"></i> My Cart(<?php echo $cartCount; ?>) - ৳ <?php 
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
                    <h1><i>Our Menu</i></h1>
                    <p class="pt-2"><i>check out your favorite food from our menu</i></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Food Area starts -->
    <section class="food-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="section-top">
                        <h3><span class="style-change">we serve</span> <br>delicious food</h3>
                        <p class="pt-3">We are serving very delicious local food.all of the delicious items are served by our expert service team.so don't miss the chance to get your delicous local food from our site.thank you. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                			<?php
				while($rows = mysqli_fetch_assoc($result))
				{
			?>		<div class="col-md-4 col-sm-6">
                    <div class="single-food">
                        <div class="food-img">
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($rows['item_image']); ?>" class="img-fluid" alt="">
                        </div>
                        <div class="food-content">
                            <div class="d-flex justify-content-between">
                                <h5><?php echo $rows['item_name']; ?></h5>
                                <span class="style-change">৳ <?php echo $rows['item_price']; ?></span>
                            </div>
                            <p class="pt-3"><?php echo $rows['item_details']; ?></p>
                            <form method="post" action="customerValidation.php">
                                <input style="width: 50px;height: 30px;border-radius: 5px; text-align: center; background-color: aliceblue;" type="text" name="quantity" value="1">
                                <input type="hidden" name="item_id" value="<?php echo $rows['item_id']; ?>">
							    <input type="hidden" name="item_name" value="<?php echo $rows['item_name']; ?>">
							    <input type="hidden" name="item_price" value="<?php echo $rows['item_price']; ?>">
                                <button type="submit" class="template-btn mt-3" style="background-color: aliceblue; margin-left: 30px;" name="cartButton">ADD TO CART</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
			
		    <?php  } ?>
               
            </div>
        </div>
    </section>
    <!-- Food Area End -->
    

    <!-- Table Area Starts -->
    <section class="table-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top2 text-center">
                        <h3>Book <span>Catering service</span> for any festival</h3>
                        <p><i>Beast kind form divide night above let moveth bearing darkness.</i></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <form action="#">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            </div>
                            <input type="text" id="datepicker">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                            </div>
                            <input type="text" id="datepicker2">
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <span class="input-group-text"><i class="fa fa-user-o"></i></span>
                            </div>
                            <input type="text">
                        </div>
                        <div class="table-btn text-center">
                            <a href="#" class="template-btn template-btn2 mt-4">Confirm booking</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Table Area End -->

    <!-- Footer Area Starts -->
    <footer class="footer-area">
        <div class="footer-widget section-padding">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="single-widget single-widget1">
                            <a href="index.html"><img src="assets/images/logo/grihini.png" alt=""></a>
                            <p class="mt-3">Which morning fourth great won't is to fly bearing man. Called unto shall seed, deep, herb set seed land divide after over first creeping. First creature set upon stars deep male gathered said she'd an image spirit our</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="single-widget single-widget2 my-5 my-md-0">
                            <h5 class="mb-4">contact us</h5>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-map-marker"></i>
                                </div>
                                <div class="info-text">
                                    <p>United city, Badda </p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="info-text">
                                    <p>+8801770353601</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <div class="info-text">
                                    <p>support@grihini.com</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-md-6">
                        <span><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" target="_blank">grihini</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></span>
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <div class="social-icons">
                            <ul>
                                <li class="no-margin">Follow Us</li>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Area End -->


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
