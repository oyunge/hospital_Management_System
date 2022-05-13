<?php
// 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
session_start();
include_once('include/config.php');

if (isset($_POST["enter_pin"]))
{
    $pin = $_POST["pin"];
    $user_id = $_SESSION["users"]->id;

    $conn = mysqli_connect("localhost", "root", "", "hms");
     
    $sql = "SELECT * FROM users WHERE id = '$user_id' AND pin = '$pin'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0)
    {
        $sql = "UPDATE users SET pin = '' WHERE id = '$user_id'";
        mysqli_query($conn, $sql);

        $_SESSION["users"]->is_verified = true;
       header("Location: dashboard.php");
    }
    else
    {
        echo "Wrong pin";
    }
}
?>
<!DOCTYPE html>
<head>
    <title>
        enter pin
    </title>
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
</head>
<body>
<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo margin-top-30">
				<a href="../index.html"><h2> HMS | OTP CODE</h2></a>
				</div>

				<div class="box-login">
                <form method="POST" action="enter-pin.php">
    <p>
        <input type="text" name="pin"  placeholder="Enter code">
    </p>
    
<input type="submit" name="enter_pin">
</form>

					<div class="copyright">
						&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> HMS</span>. <span>All rights reserved</span>
					</div>
			
				</div>

			</div>
		</div>
</body>

