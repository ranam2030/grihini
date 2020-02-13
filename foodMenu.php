<?php
    include('adminValidation.php');
	$con = mysqli_connect('localhost','root','','grihini');

    if(isset($_GET['logout']))
    {
        session_destroy();
        unset($_SESSION['user_name']);
        header("location: admin.php");
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
    <link rel="stylesheet" href="assets/css/login.css">
    
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
                        <a href="adminPage.php"><img src="assets/images/logo/grihini.png" alt="logo"></a>
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
                            <li class="active"><a href="adminPage.php">home</a></li>
                            <li><a href="about.php">Menu</a></li>
                            <li><a href="menu.php">Processing</a></li>
                            <li><a href="contact-us.php">Pending</a></li>
                            <li><a href="contact-us.php">Delivered</a></li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Area End -->

    <!-- Banner Area Starts -->
    <!-- Banner Area End -->

    <a href="addItem.php" style="text-decoration: none;background: green;color: white;text-align: center;margin-left: 400px;">ADD ITEM</a>


    <div>
            <?php
                while($rows = mysqli_fetch_assoc($result))
                {
            ?>      
            <div style="text-align: center;display:inline-block;height:400px;width:350px;margin-top: 50px;margin-left:55px;background-color: white;border-radius: 8px;">
                <span style="float:left;display:inline-block;height:500px;width:100%;overflow:auto;">
                        <a style="text-decoration: none;font-size: 25px;color: black;" href="#"><?php echo $rows['item_name']; ?></a>
                        <p style="font-size: 17px; font-weight: bold;width: 100px;background: green;color: white;margin-left: 40%;border-radius: 5px;">TK: <?php echo $rows['item_price']; ?></p>
                        <img style="width:200px;height:200px;border-radius: 8px;margin-top: 0px;" src="data:image/jpeg;base64,<?php echo base64_encode($rows['item_image']); ?>">
                        <br/>
                

                
                    <?php echo $rows['item_details']; ?>
                    <form method="post" action="adminValidation.php">
                        <div style="margin-top: 10px;">
                            <input type="hidden" name="item_id" value="<?php echo $rows['item_id']; ?>">
                            <button style="background: green;color:white;font-size: 18px;margin-left: 20px;border-radius: 5px;" type="submit" name="edtButton">Edit</button>
                            <button style="background: green;color:white;font-size: 18px;margin-left: 20px;border-radius: 5px;" type="submit" name="rmvButton">Remove</button>
                            
                        </div>
                    </form>
                    
                </span>

                </div>
            
        <?php  } ?>     
        
    </div>



    
    <!-- Footer Area End -->


    <!-- Javascript -->
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
	<script src="assets/js/vendor/bootstrap-4.1.3.min.js"></script>
    <script src="assets/js/vendor/wow.min.js"></script>
    <script src="assets/js/vendor/owl-carousel.min.js"></script>
    <script src="assets/js/vendor/jquery.datetimepicker.full.min.js"></script>
    <script src="assets/js/vendor/jquery.nice-select.min.js"></script>
    <script src="assets/js/main.js"></script>
    
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <?php
    if(isset($_GET['status']))
    {
      $status=$_GET['status'];
      if($status=='loginSuccess')
      {
        echo "<script>swal('Congratulation!', 'You loged in successfully!', 'success');</script>";
      }
    }
  ?>
</body>
</html>
