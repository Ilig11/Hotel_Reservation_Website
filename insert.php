<?php
// insert into database inputs from from
$first_name = $_POST['inputFName'];
$middle_name = $_POST['inputMName'];
$family_name = $_POST['inputFamName'];
$email = $_POST['inputEmail'];
$guests = $_POST['inputNumberGuests'];
$hotel = $_POST['inputHotel'];
$room = $_POST['inputRoom'];
$check_in = $_POST['arrival'];
$check_out = $_POST['departure'];

if (!empty($first_name) || !empty($middle_name) || !empty($family_name) || !empty($email) || !empty($guests) || !empty($hotel) || !empty($room) || !empty($check_in) || !empty($check_out)) {
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "website";
    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
    if (mysqli_connect_error()) {
        die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
    } else {
        $SELECT = "SELECT email From reservations Where email = ? Limit 1";
        $INSERT = "INSERT Into reservations (first_name, middle_name, family_name, email, guests, hotel, room, check_in, check_out) values(?, ?, ?, ?, ?, ?, ?, ?, ?)";
        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;
        if ($rnum==0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssissss", $first_name, $middle_name, $family_name, $email, $guests, $hotel, $room, $check_in, $check_out);
            $stmt->execute();
            // create a message to display on the reservation page
            $message = "Thank you for your reservation. We will contact you shortly.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            header("refresh:0; url=index.php");
            // redirect to homepage
        

        } else {
            
            // create a message dialog box then return to homepage
            echo "<script type='text/javascript'>alert('Someone already reserved that email');</script>";
            header("refresh:0; url=index.php");
            
        }
        $stmt->close();
        $conn->close();
    }
} else {
    echo "All field are required";
    die();
}

?>

