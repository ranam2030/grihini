<?php include('cookValidation.php')?>

<?php

	if(isset($_GET['logout']))
	{
		session_destroy();
		unset($_SESSION['user_name']);
		header("location: index.php");
	}

	$con = mysqli_connect('localhost','root','','grihini');

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
    <title>Contact Us</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/x-icon">

    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/animate-3.7.0.css">
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap-4.1.3.min.css">
    <link rel="stylesheet" href="assets/css/owl-carousel.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/updateProfile.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
</head>
<body>
    <?php include('getCookProfile.php'); ?>
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
    <section class="banner-area banner-area2 contact-bg text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1><i>Contact Us</i></h1>
                    <p class="pt-2"><i>Contact with us by the following information</i></p>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Area End -->

    <div class="header">
        <h2>Update Profile</h2>
    </div>
    
    <form method="post" action="cookUpdateProfile.php">
        <div class="input-group">
            <label>First Name</label>
            <input type="text" name="cookUpFirstName" value="<?php echo $_SESSION['first_name']; ?>">
        </div>
        <div class="input-group">
            <label>Last Name</label>
            <input type="text" name="cookUpLastName" value="<?php echo $_SESSION['last_name']; ?>">
        </div>
        <div class="input-group">
            <label>Email</label>
            <input type="email" name="cookUpEmail" value="<?php echo $_SESSION['email']; ?>">
        </div>
        <div class="input-group">
            <label>Phone Number</label>
            <input type="text" name="phnNo" value="<?php echo $_SESSION['phn_no']; ?>">
        </div>
        <div class="input-group">
            <label>Date of Birth</label>
            <input type="Date" name="dob" value="<?php echo $_SESSION['dob']; ?>">
        </div>
        <div class="input-group">
            <label>Address</label>
            <input type="text" name="cookUpAddress" value="<?php echo $_SESSION['address']; ?>">
        </div>
        <div class="input-group">
            <label>Details</label>
            <input type="textarea" name="cookUpDetails" value="<?php echo $_SESSION['details']; ?>">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="cookUpBtn">Update</button>
        </div>

  </form>

    <!-- Javascript -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
	<script src="assets/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <script src="assets/js/vendor/owl-carousel.min.js"></script>
    <script src="assets/js/vendor/jquery.datetimepicker.full.min.js"></script>
    <script src="assets/js/vendor/jquery.nice-select.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDpfS1oRGreGSBU5HHjMmQ3o5NLw7VdJ6I"></script>
    <script src="assets/js/vendor/gmaps.min.js"></script>
    <script src="assets/js/main.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    
</body>
</html>
