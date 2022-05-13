
<?php

session_start();
error_reporting(0);
//include_once('include/config.php');
require_once "vendor/autoload.php";
use Twilio\Rest\Client;

$sid = "AC8273bde3c35ac88939244f1b83bf0786";
$token = "9f3ca433d830406bacbed2fe6cceb877";


if(isset($_POST["login"]))
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    $conn = mysqli_connect("localhost", "root", "", "hms");
    $sql = "SELECT * FROM  users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

	if(mysqli_num_rows($result)){
        $row = mysqli_fetch_object($result);
        if($password == $row->password)
        {
            //checking if user has enabled two factor authentication
            if($row->is_tfa_enabled){

				$row->is_verified = true;
				$_SESSION["users"] = $row;
	
				$pin = rand(0, 9) . rand(0 ,9) . rand(0, 9) . rand(0 ,9) .rand(0, 9) . rand(0 ,9);
	
				$sql = "UPDATE users SET pin = '$pin' WHERE id = '" . $row->id . "'";
				mysqli_query($conn, $sql);
	
				$client = new Client($sid, $token);
				$client->messages->create(
					$row->phone, array(
						"from" => "+17473024474",
						"body" => "Uplifted Care Services Minessota authentication code: . $pin"
					)
					 );
	
				header("Location: enter-pin.php");
				}
	
            else
            {
                $row->is_verified = false;
                $_SESSION["users"] = $row;

                header("Location: dashboard.php");
            }
        }
        else
        {
            echo "wrong password";
        }
    }
    else{
        echo "Not exists";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User-Login</title>
		
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
	<body class="login">
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo margin-top-30">
				<a href="../index.html"><h2> HMS | Patient Login</h2></a>
				</div>

				<div class="box-login">
					<form class="form-login" action="user-login.php" method="post">
						<fieldset>
							<legend>
								Sign in to your account
							</legend>
							<p>
								Please enter your name and password to log in.<br />
								<span style="color:red;"><?php echo $_SESSION['errmsg']; ?><?php echo $_SESSION['errmsg']="";?></span>
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="email" placeholder="email">
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Password">
									<i class="fa fa-lock"></i>
									 </span><a href="forgot-password.php">
									Forgot Password ?
								</a>
							</div>
							<div class="form-actions">
								
							<input type="submit" name="login">

							</div>
							<div class="new-account">
								Don't have an account yet?
								<a href="registration.php">
									Create an account
								</a>
							</div>
						</fieldset>
					</form>

					<div class="copyright">
						&copy; <span class="current-year"></span><span class="text-bold text-uppercase"> HMS</span>. <span>All rights reserved</span>
					</div>
			
				</div>

			</div>
		</div>
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
	
		<script src="assets/js/main.js"></script>

		<script src="assets/js/login.js"></script>
		<!-- <script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script> -->
	
	</body>
	<!-- end: BODY -->
</html>