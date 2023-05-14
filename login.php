<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<title>Login Webtical</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	<!-- Custom CSS -->
	<style type="text/css">
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			background: rgb(4, 186, 166);
			background: linear-gradient(90deg, rgb(4, 168, 149) 0%, rgb(2, 102, 94) 100%);
		}

		.login-form h2 {
			color: #43ceb0;
		}

		.login-form {
			background-color: #ffffff;
			box-shadow: 0px 1px 10px #002135;
			padding: 30px;
			border-radius: 5px;
			margin-top: 20px;
			max-width: 500px;
			margin-left: auto;
			margin-right: auto;
		}

		.login-form input[type="text"],
		.login-form input[type="password"] {
			border-radius: 3px;
			border: none;
			background-color: #f5f8fa;
			padding: 10px;
			margin-bottom: 20px;
			box-shadow: none;
			border: 1px solid #ccc;
			width: 100%;
		}

		.login-form input[type="text"]:focus,
		.login-form input[type="password"]:focus {
			border: 1px solid #43ceb0;
			box-shadow: 0 0 10px #43ceb0;
			outline: none;
		}

		.login-form .btn {
			background-color: #34a18a;
			border-radius: 3px;
			border: none;
			color: #ffffff;
			padding: 10px 20px;
			cursor: pointer;
			width: 100%;
		}

		.login-form .btn:hover {
			background-color: #43ceb0;
			color: #ffffff;
			transition: all .3s ease-in-out;
		}

		.login-form .btn i {
			margin-right: 5px;

		}

		.login-form .form-check-label {
			font-size: 14px;
			color: #7a7a7a;
			margin-bottom: 10px;
			display: block;
		}

		input[type=checkbox],
		input[type=radio] {
			box-sizing: border-box;
			padding: 0;
			accent-color: #43ceb0;
		}

		.login-form .logo {
			text-align: center;
			margin-bottom: 20px;
		}

		.login-form .logo img {
			width: 150px;
			height: auto;
		}

		.login-form .forgot-password,
		.login-form .create-account {
			display: block;
			text-align: center;
			margin-top: 10px;
			color: #37ac92;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<form class="login-form" action="./login.php" method="post">
					<div class="logo">
						<img src="./img/LOGO.png">
					</div>

					<h2 class="text-center">Login</h2>
					<br>
					<div class="form-group">
						<label for="username & E-mail">Username or E-mail address</label>
						<input type="text" class="form-control" id="username" name="username" placeholder="Enter username or E-mail">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
					</div>
					<div class="form-group form-check">
						<input type="checkbox" class="form-check-input" id="remember-me">
						<label class="form-check-label" for="remember-me">Remember me</label>
					</div>
					<button type="submit" name="ok" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i>Login</button>
					<a href="#" class="forgot-password">Forgot Password?</a>
					<a href="/web-test/singup.php" class="create-account">Create New Account</a>
				</form>
			</div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-zML4GHUv7VW4O8sydSyLqb//LeIo16v7MmH8C9P9oavNbYfj+zAwKLWTRerHr2Cz" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-q8i/X9YF+20GdOSKk57NkKj0EwUNlGwR/qlZfjKWHpX9+MGBbE98s1mHMc/KJ8Qr" crossorigin="anonymous"></script>
	<?php
if (isset($_POST['ok'])) {
  if (isset($_POST['username'] , $_POST['password'])) {
    $username = $_POST['username'];
    $psw = $_POST['password'];
	$_SESSION['loggedIn'] = true;
	$_SESSION['username'] = $username;

    require("./config/connexion.php");

    $selUser=$db->prepare('SELECT * FROM utilisateur WHERE (email = :email OR username =:email) AND password = :psw');
    $selUser->bindParam(':email', $username);
    $selUser->bindParam(':psw', $psw);
    $selUser->execute();

    $countUser=$selUser->rowCount();

    if($countUser > 0){
      header('Location: home.php');
    }else
      echo'';
  }
}
?>
</body>

</html>