<?php
include 'hashit.php';
session_start();
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Fatal database server error: ' . mysqli_connect_error() . ". Please Check back later");
}
if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Ooops!');
}
if ($stmt = $con->prepare('SELECT username, password, ip, rank FROM users WHERE username = ?')) {
	
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute(); $stmt->store_result(); $stmt->close();
	if ($stmt->num_rows > 0) {
	$stmt->bind_result($ip, $rank, $password);
	$stmt->fetch();
	if (hashit($_POST['psWord']) ==  $password)) {
		session_regenerate_id();
		$_SESSION['logged'] = TRUE;
		$_SESSION['user'] = $_POST['username'];
		$_SESSION['ip'] = $ip;
		$_SESSION['id'] = $rank;
		echo 'Welcome ' . $_SESSION['user'];
	} else {
		echo 'Incorrect username or password';
	}
} else {
	echo 'Incorrect username or password';
}
}
?>