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
    <title>grihini</title>

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
	<header class="header-area">
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
                    <div class="main-menu">
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
                                        <li><a href="cookProfile.php">My Profile</a></li>
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
                                            <li style="font-weight: bold;"><a style="color: black; text-decoration: none;margin: 0px;padding: 0px;" href="showOrder.php?notf=<?php echo $value['notification_id']; ?>&uname=<?php echo $value['cook_user_name']; ?>&order_id=<?php echo $value['order_id']; ?>"><?php echo $value['consumer_user_name'].' '.$value['notification_details']; ?></a></li>
                                        </ul>
                                    <?php       
                                        }
                                        else
                                        {
                                    ?>
                                            <ul>
                                                <li><a style="color: #8c8c8c; text-decoration: none;margin: 0px;padding: 0px;" href="showOrder.php?notf=<?php echo $value['notification_id']; ?>&uname=<?php echo $value['cook_user_name']; ?>&order_id=<?php echo $value['order_id']; ?>"><?php echo $value['consumer_user_name'].' '.$value['notification_details']; ?></a>
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
    <section class="banner-area text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h6>the most interesting food in the world</h6>
                    <h1>Discover the <span class="prime-color">Homemade</span><br>  
                    <span class="style-change"> <span class="prime-color">food</span> from local housewives</span></h1>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <!-- Welcome Area Starts -->
    <section class="welcome-area section-padding2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 align-self-center">
                    <div class="welcome-img">
                        <img src="assets/images/welcome-bg.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-6 align-self-center">
                    <div class="welcome-text mt-5 mt-md-0">
                        <h3><span class="style-change">welcome</span> <br>to grihini</h3>
                        <p class="pt-3">Grihini is an online platform where people can order homemade fresh food.Grihini will provide food to you.</p>
                        <a href="menu.php" class="template-btn mt-3">order now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Welcome Area End -->

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

    <!-- Reservation Area Starts -->
    <div class="reservation-area section-padding text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2>Natural ingredients and testy food</h2>
                    <h4 class="mt-4">some trendy and popular courses offerd</h4>
                    <a href="menu.php" class="template-btn template-btn2 mt-4">Order Proposal</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Reservation Area End -->
    
    <!-- Deshes Area Starts -->
    <div class="deshes-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top2 text-center">
                        <h3>Our <span>special</span> deshes</h3>
                        <p><i>Some of our special deshes are given below </i></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-6 align-self-center">
                    <h1>01.</h1>
                    <div class="deshes-text">
                        <h3><span>Garlic</span><br> green beans</h3>
                        <p class="pt-3"> Garlic green beans is our top special item. it's very much spicy and delicious food.we are using chicken, bread crumbs, onions, eggs, garlic, salt and ground black pepper, olive oil to make this Garlic green beans.</p>
                        <span class="style-change">৳ 120</span>
                        <a href="#" class="template-btn3 mt-3">order proposal <span><i class="fa fa-long-arrow-right"></i></span></a>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-2 col-md-6 align-self-center mt-4 mt-md-0">
                    <img src="assets/images/deshes1.png" alt="" class="img-fluid">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-5 col-md-6 align-self-center order-2 order-md-1 mt-4 mt-md-0">
                    <img src="assets/images/deshes2.png" alt="" class="img-fluid">
                </div>
                <div class="col-lg-5 offset-lg-2 col-md-6 align-self-center order-1 order-md-2">
                    <h1>02.</h1>
                    <div class="deshes-text">
                        <h3><span>Lemon</span><br> rosemary chicken</h3>
                        <p class="pt-3"> .</p>
                        <span class="style-change">৳ 200</span> 
                        <a href="#" class="template-btn3 mt-3">Lemon rosemary chicken is a top rated item in this site.this is a alltime selling item of us. we are using curcuma, garlic, chilis, deshi chicken, soybean oil, solts to make this lemon rosmery chicken.<span><i class="fa fa-long-arrow-right"></i></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Deshes Area End -->

    <!-- Testimonial Area Starts -->
    <section class="testimonial-area section-padding4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top2 text-center">
                        <h3>Customer <span>says</span></h3>
                        <p><i>our customers are commenting on us</i></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="testimonial-slider owl-carousel">
                        <div class="single-slide d-sm-flex">
                            <div class="customer-img mr-4 mb-4 mb-sm-0">
                                <img src="assets/images/tushar.jpg" alt="">
                            </div>
                            <div class="customer-text">
                                <h5>Md tushar</h5>
                                <span><i>Customer from banani, dhaka</i></span>
                                <p class="pt-3">Very good and timely service..i want to give 5 out of 5 rating to this site. thank you grihini.</p>
                            </div>
                        </div>
                        <div class="single-slide d-sm-flex">
                            <div class="customer-img mr-4 mb-4 mb-sm-0">
                                <img src="assets/images/jiku.jpg" alt="">
                            </div>
                            <div class="customer-text">
                                <h5>Jiku mollick</h5>
                                <span><i>Customer from rangamati, chittagong</i></span>
                                <p class="pt-3"> Very first service and food quality is good to. i wnat to give 4.8 out of 5 to this site.</p>
                            </div>
                        </div>
                        <div class="single-slide d-sm-flex">
                            <div class="customer-img mr-4 mb-4 mb-sm-0">
                                <img src="assets/images/joy.jpg" alt="">
                            </div>
                            <div class="customer-text">
                                <h5>Ahnaf sahriar chowdhury</h5>
                                <span><i>Customer from durgapur, Mymensing</i></span>
                                <p class="pt-3">In the end there is a good site in market to produce good quality food. thank you very much grihini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Testimonial Area End -->

    <!-- Update Area Starts -->
    <section class="update-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top2 text-center">
                        <h3>Our <span>food</span> update</h3>
                        <p><i>Beast kind form divide night above let moveth bearing darkness.</i></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="single-food">
                        <div class="food-img">
                            <img src="assets/images/update1.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="food-content">
                            <div class="post-admin d-lg-flex mb-3">
                                <span class="mr-5 d-block mb-2 mb-lg-0"><i class="fa fa-user-o mr-2"></i>Admin</span>
                                <span><i class="fa fa-calendar-o mr-2"></i>18/09/2018</span>
                            </div>
                            <h5>Double Decker Chicken Burger</h5>
                            <p>we are introducing a new item called double decker chicken burger from the upcomming month.</p>
                            <a href="#" class="template-btn3 mt-2">read more <span><i class="fa fa-long-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-food my-5 my-md-0">
                        <div class="food-img">
                            <img src="assets/images/update2.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="food-content">
                            <div class="post-admin d-lg-flex mb-3">
                                <span class="mr-5 d-block mb-2 mb-lg-0"><i class="fa fa-user-o mr-2"></i>Admin</span>
                                <span><i class="fa fa-calendar-o mr-2"></i>20/09/2018</span>
                            </div>
                            <h5>Chicken Shawarma</h5>
                            <p>we are introducing a new item called chicken shawarma from the upcomming month.</p>
                            <a href="#" class="template-btn3 mt-2">read more <span><i class="fa fa-long-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="single-food">
                        <div class="food-img">
                            <img src="assets/images/update3.jpg" class="img-fluid" alt="">
                        </div>
                        <div class="food-content">
                            <div class="post-admin d-lg-flex mb-3">
                                <span class="mr-5 d-block mb-2 mb-lg-0"><i class="fa fa-user-o mr-2"></i>Admin</span>
                                <span><i class="fa fa-calendar-o mr-2"></i>22/09/2018</span>
                            </div>
                            <h5>Beef Kabab</h5>
                            <p>we are introducing a new item called beef kabab from the upcomming month.</p>
                            <a href="#" class="template-btn3 mt-2">read more <span><i class="fa fa-long-arrow-right"></i></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Update Area End -->

    <!-- Table Area Starts -->
    <section class="table-area section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-top2 text-center">
                        <h3>Book <span>Catering service</span>   for any festival</h3>
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
                            <a href="#" class="template-btn template-btn2 mt-4">confirm booking</a>
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
                                    <p>1234 Some St San Francisco, CA 94102, US 1.800.123.4567 </p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-phone"></i>
                                </div>
                                <div class="info-text">
                                    <p>(123) 456 78 90</p>
                                </div>
                            </div>
                            <div class="d-flex">
                                <div class="into-icon">
                                    <i class="fa fa-envelope-o"></i>
                                </div>
                                <div class="info-text">
                                    <p>support@axiomthemes.com</p>
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
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This website is mad<i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="#" target="_blank">grihini</a>
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
    
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


	<?php
	    if(isset($_GET['status']))
	    {
	      $status=$_GET['status'];
	      if($status=='loginSuccess')
	      {
	        echo "<script> swal('Congratulation!', 'You loged in successfully!', 'success');</script>";
	      }
	    }
  	?>


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
