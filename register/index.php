<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Register | Gadgets Pedia</title>

	<!-- Icon and favicon start -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="apple-touch-icon" sizes="180x180" href="../imgs/icon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="../imgs/icon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="../imgs/icon/favicon-16x16.png">
	<link rel="manifest" href="../imgs/icon/site.webmanifest">
	<!-- Icon and favicon End -->
</head>

<body>
	<header>
		<h1><a href="../">Gadgets Pedia</a></h1>
	</header>
	<div class="container">
		<div class="register">
			<h1>Register</h1>
			<p>Already have an account? <a href="../login/.">Login</a></p>
			<form action="register.php" method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
				<label for="password1">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password1" placeholder="Password" id="password1" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
				<label for="password2">
					<i class="fas fa-check-circle"></i>
				</label>
				<input type="password" name="password2" placeholder="Confirm password" id="password2" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Your password must same with password above" required>
				<input type="submit" value="Register">
			</form>
		</div>
	</div>
</body>

</html>