<?php
include '../phplogin/functions.php';
$con = mysqli_connect_to_database();

if (mysqli_connect_errno()) {
	// If there is an error with the connection, stop the script and display the error.
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}
// Now we check if the data was submitted, isset() function will check if the data exists.
if (!isset($_POST['username'], $_POST['password1'], $_POST['password2'], $_POST['email'])) {
	// Could not get the data that should have been sent.
	exit('Please complete the registration form!');
}
// Make sure the submitted registration values are not empty.
if (empty($_POST['username']) || empty($_POST['password1']) || empty($_POST['password2']) || empty($_POST['email'])) {
	// One or more values are empty.
	exit('Please complete the registration form');
}

//Make sure the password lenght is 8 character
if (strlen($_POST['password1']) <= 8) {
	exit('Your password must be have at least <br>
		<ul>
			<li>8 characters long</li>
			<li>1 uppercase & 1 lowercase character</li>
			<li>1 number</li>
		</ul>
	');
}

//Make sure password and confirm password are same
if ($_POST['password1'] != $_POST['password2']) {
	exit('Comfirm password are not same');
}

// We need to check if the account with that username exists.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	// Bind parameters (s = string, i = int, b = blob, etc), hash the password using the PHP password_hash function.
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	// Store the result so we can check if the account exists in the database.
	if ($stmt->num_rows > 0) {
		// Username already exists
		echo 'Username exists, please choose another!';
	} else {
		// Username doesnt exists, insert new account
		if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, role, code) VALUES (?, ?, ?, "costumer", ?)')) {
			// We do not want to expose passwords in our database, so hash the password and use password_verify when a user logs in.
			$password = password_hash($_POST['password1'], PASSWORD_DEFAULT);
			$verification_code = generate_code_verification();
			$stmt->bind_param('sssi', $_POST['username'], $password, $_POST['email'], $verification_code);
			$stmt->execute();
			send_verification_email($_POST['email'], $verification_code);
			header('Location: auth.php');
		} else {
			// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
			echo 'Could not prepare statement!';
		}
	}
	$stmt->close();
} else {
	// Something is wrong with the sql statement, check to make sure accounts table exists with all 3 fields.
	echo 'Could not prepare statement!';
}
$con->close();

function generate_code_verification()
{
	return random_int(100000, 999999);
}

function send_verification_email($email, $code)
{
	$to = $email;
	$subject = 'Verification Code | Gadget Pedia';
	$message = '
	Your verification code is : ' . $code . 'valid until 15 mins';

	$headers = 'From: galangaidil45@gmail.com' . "\r\n";
	return mail($to, $subject, $message, $headers);
}
