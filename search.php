<?php

$last_name = $_POST['SearchFamName'];
$email = $_POST['SearchEmail'];

if (!empty($last_name) || !empty($email)) {
    $host = "localhost:3307";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "website";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT * From reservations Where family_name = ? AND email = ? Limit 1";
        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("ss", $last_name, $email);
        $stmt->execute();
        $stmt->bind_result($first_name, $middle_name, $family_name, $email, $guests, $hotel, $room, $check_in, $check_out);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        $stmt->fetch();
		if ($rnum==0) {
			echo "<script type='text/javascript'>alert('Unfortunately that reservation does not exist. Book now to create a new reservation.');</script>";
			header("refresh:0; url=index.php");
		}
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All fields are required";
    die();
}

?>


<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Luxe Hotel - Demo for ITCC13</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="Final Project - ITCC13" />

		<meta property="og:title" content=""/>
		<meta property="og:image" content=""/>
		<meta property="og:url" content=""/>
		<meta property="og:site_name" content=""/>
		<meta property="og:description" content=""/>
		<meta name="twitter:title" content="" />
		<meta name="twitter:image" content="" />
		<meta name="twitter:url" content="" />
		<meta name="twitter:card" content="" />

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
		<link rel="shortcut icon" href="favicon.ico">
		<!-- <link href='https://fonts.googleapis.com/css?family=Lato:400,100,100italic,300,300italic,400italic,700italic,900,700,900italic' rel='stylesheet' type='text/css'> -->

		<!-- STYLESHEETS -->
		<!-- Dropdown Menu -->
		<link rel="stylesheet" href="css/superfish.css">
		<!-- CS Select -->
		<link rel="stylesheet" href="css/cs-select.css">
		<link rel="stylesheet" href="css/cs-skin-border.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
		<!-- Themify Icons -->
		<link rel="stylesheet" href="css/themify-icons.css">
		<!-- Flat Icon -->
		<link rel="stylesheet" href="css/flaticon.css">
		<!-- Icomoon -->
		<link rel="stylesheet" href="css/icomoon.css">
		<!-- Flexslider  -->
		<link rel="stylesheet" href="css/flexslider.css">
		<!-- Style -->
		<link rel="stylesheet" href="css/style.css">

		<!-- Modernizr JS -->
		<script src="js/modernizr-2.6.2.min.js"></script>
		<!-- FOR IE9 below -->
		<!--[if lt IE 9]>
		<script src="js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
	<div id="fh5co-wrapper">
	<div id="fh5co-page">

		<!--Header: Start-->
		<div id="fh5co-header">
		<header id="fh5co-header-section">
		<div class="container">
		<div class="nav-header">
			<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
			<h1 id="fh5co-logo"><a href="index.php">Luxe</a></h1>
			<nav id="fh5co-menu-wrap" role="navigation">
				<ul class="sf-menu" id="fh5co-primary-menu">
					<li><a class="active" href="index.php">Home</a></li>
					<li>
						<a href="#" class="fh5co-sub-ddown">Hotel</a>
						<ul class="fh5co-sub-menu">
							<li><a href="#">Luxe Hotel - Manila</a></li><!--ADD-->
							<li><a href="#">Deluxe Hotel - Cebu</a></li><!--ADD-->
							<li><a href="#">Bora Hotel - Cagayan de Oro</a></li><!--ADD--> 
						</ul>
					</li>
					<li><a href="book_modal" data-toggle="modal" data-target="#book_modal">Book</a></li>
					<li><a href="search_modal" data-toggle="modal" data-target="#search_modal">Check Reservation</a></li>
					<li><a href="#">Contact</a></li> <!--ADD-->
				</ul>
			</nav>
		</div>
		</div>
		</header>	
		</div>
		<!-- Header: End -->

		<!-- Modals: Start -->
		<!-- Check Reservation Modal-->
		<div class="modal fade" id="search_modal" tabindex="-1" role="dialog" aria-labelledby="search_modalTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">

				<h5 class="modal-title" id="search_modalTitle">Check Reservation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>
			<div class="modal-body">

				<form action="search.php" method="POST">
					<div class="form-group">
						<label for="SearchEmail">Email Address</label>
						<input type="email" class="form-control" name="SearchEmail" aria-describedby="emailHelp" placeholder="Enter Email Address" required>
						<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
					</div>
					<div class="form-group">
						<label for="SearchFamName">Last Name</label>
						<input type="text" class="form-control" name="SearchFamName" placeholder="Enter Last Name" required>
					</div>
					<button type="submit" class="btn btn-primary">Check My Reservation</button>
				</form>
				
			</div>
		</div>
		</div>
		</div>	

		<!-- Book Reservation Modal-->
		<div class="modal fade" id="book_modal" tabindex="-1" role="dialog" aria-labelledby="book_modal" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle">Reservation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<form action="insert.php" method="POST">
					<div class="form-row">
						<div class="form-group col-md-4">
						<label for="inputFName">First Name</label>
						<input type="text" class="form-control" id="inputFName" name="inputFName" required>
						</div>
						<div class="form-group col-md-4">
						<label for="inputMName">Middle Name</label>
						<input type="text" class="form-control" id="inputMName" name="inputMName">
						</div>
						<div class="form-group col-md-4">
						<label for="inputFamName">Family Name</label>
						<input type="text" class="form-control" id="inputFamName" name="inputFamName" required>
						</div>
					</div>

					<div class="form-group">
						<label for="inputEmail">Email Address</label>
						<input type="text" class="form-control" id="inputEmail" name="inputEmail" required>
					</div>
					
					<div class="form-group">
						<label for="inputNumberGuests">Number of Guests</label>
						<input type="number" class="form-control" id="inputNumberGuests" name="inputNumberGuests" placeholder="0" min="1" max="5" required>
					</div>
												
					<div class="form-group">
						<label for="inputHotel">Hotel</label>
						<select id="inputHotel" class="form-control" name="inputHotel" required>
							<option selected value="">Choose...</option>
							<option value="Luxe Hotel - Manila">Luxe Hotel - Manila</option>
							<option value="Deluxe Hotel - Cebu">Deluxe Hotel - Cebu</option>
							<option value="Bora Hotel - Cagayan de Oro">Bora Hotel - Cagayan de Oro</option>
						</select>
					</div>

					<div class="form-group">
						<label for="inputRoom">Room</label>
						<select id="inputRoom" class="form-control" name="inputRoom" required>
							<option selected value="">Choose...</option>
							<option value="Single Economy">Single Economy</option>
							<option value="Double Economy">Double Economy</option>
							<option value="Premium">Premium</option>
							<option value="Deluxe">Deluxe</option>
							<option value="Presidential Suite">Presidential Suite</option>
						</select>
					</div>				
											
					<div class="form-group">
						<label for="arrival-date-input">Arrival Date</label>
						<input class="form-control" type="date" value="2022-08-19" id="arrival-date-input" name="arrival" required>
					</div>

					<div class="form-group">
						<label for="departure-date-input">Departure Date</label>
						<input class="form-control" type="date" value="2022-08-19" id="departure-date-input" name="departure" required>
					</div>
					
					<div class="form-group">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="gridCheck" required>
							<label class="form-check-label" for="gridCheck">
							I agree to the <a href=rules.pdf target="_blank">rules and policies</a> of the hotel
							</label>
						</div>
					</div>

					<button type="submit" class="btn btn-primary">Book this Reservation</button>
				</form>
			</div>	
		</div>	
		</div>
		</div>		
		<!-- Modals: End -->

		<!-- Parallax: Start-->
		<div class="fh5co-parallax" style="background-image: url(images/slider1.jpg); height:80px" data-stellar-background-ratio="0.5">
			<div class="overlay">
			</div>
		</div>
		<!-- Parallax: End-->

		<!-- Reservations: Start -->
		<div id="fh5co-contact-section">
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
					<div class="col-md-12">
						<h3>Your Reservation Details</h3>
						<p>Good day Sir/Ma'am <?php echo $family_name ?>! We are so excited to accomodate you! See you soon!</p>
						<ul class="info" style="list-style: none;">
							<li><i class="ti-face-smile"></i> Guest Name: <?php echo $first_name . "   " .$middle_name ."   ". $last_name; ?></li>
							<li><i class="ti-user"></i> Accomodation:  <?php echo $guests ?></li>
							<li><i class="ti-email"></i> Email:  <?php echo $email ?></li>
							<li><i class="ti-map-alt"></i> Hotel:  <?php echo $hotel ?></li>
							<li><i class="ti-key"></i> Room:  <?php echo $room ?></li>
							<li><i class="ti-calendar"></i> Check In:  <?php echo $check_in ?></li>
							<li><i class="ti-calendar"></i> Check Out:  <?php echo $check_out ?></li>
						</ul>
					</div>
					<div class="row" style="padding-left: inherit;">
						<div class="col-md-7">
							<button><a href="index.php">Update Reservation</a></button>
						</div>
						<div class="col-md-5">
							<!-- Delete Form -->
							<form action="delete.php" method="POST">
								<input type="hidden" name="id_to_delete" value="<?php echo $email; ?>">
								<input type="submit" name="delete" value="Cancel Reservation" class="btn btn-warning">
							</form>
						</div>
					</div>

					

				</div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
		<!-- Reservations: End -->
		
		<!-- Footer: Start -->
		<footer id="footer" class="fh5co-bg-color">
			<div class="container">
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-3">
							<h3>Company</h3>
							<ul class="link">
								<li><a href="#">About Us</a></li>
								<li><a href="#">Hotels</a></li>
								<li><a href="#">Customer Care</a></li>
								<li><a href="#">Contact Us</a></li>
							</ul>
						</div>
						<div class="col-md-3">
							<h3>Our Facilities</h3>
							<ul class="link">
								<li><a href="#restaurant">Resturant</a></li>
								<li><a href="#bar">Bars</a></li>
								<li><a href="#pickup">Pick-up</a></li>
								<li><a href="#pool">Swimming Pool</a></li>
								<li><a href="#spa">Spa</a></li>
								<li><a href="#gym">Gym</a></li>
							</ul>
						</div>
						<div class="col-md-6">
							<h3>Subscribe</h3>
							<p>Sed cursus ut nibh in semper. Mauris varius et magna in fermentum. </p>
							<form action="#" id="form-subscribe">
								<div class="form-field">
									<input type="email" placeholder="Email Address" id="email">
									<input type="submit" id="submit" value="Send">
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<ul class="social-icons">
						<li>
							<a href="#"><i class="icon-twitter-with-circle"></i></a>
							<a href="#"><i class="icon-facebook-with-circle"></i></a>
							<a href="#"><i class="icon-instagram-with-circle"></i></a>
							<a href="#"><i class="icon-linkedin-with-circle"></i></a>
						</li>
					</ul>
				</div>
				<div class="col-md-3">
					<div class="copyright">
						<p><small>&copy; ITCC 13.1 Final Project <br> All Rights Reserved. <br>
						Designed by <strong>Abquina, Craig</strong> and <strong>Montano, George Jose</strong><br>
						<a href="https://github.com/Yoshilute/Hotel_Reservation_Website" target="_blank">View Project's GitHub Repository</a></small></p>
					</div>
				</div>
			</div>
			</div>
		</footer>
		<!-- Footer: End -->
	</div>
	<!-- END fh5co-page -->

	</div>
	<!-- END fh5co-wrapper -->
	
	<!-- Javascripts -->
	<script src="js/jquery-2.1.4.min.js"></script>
	<!-- Dropdown Menu -->
	<script src="js/hoverIntent.js"></script>
	<script src="js/superfish.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Counters -->
	<script src="js/jquery.countTo.js"></script>
	<!-- Stellar Parallax -->
	<script src="js/jquery.stellar.min.js"></script>
	<!-- Owl Slider -->
	<!-- // <script src="js/owl.carousel.min.js"></script> -->
	<!-- Date Picker -->
	<script src="js/bootstrap-datepicker.min.js"></script>
	<!-- CS Select -->
	<script src="js/classie.js"></script>
	<script src="js/selectFx.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>
	<!-- Google Map -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCefOgb1ZWqYtj7raVSmN4PL2WkTrc-KyA&sensor=false"></script>
	<script src="js/google_map.js"></script>

	<script src="js/custom.js"></script>

</body>
</html>