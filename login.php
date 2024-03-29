<?php

if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
    $link = "https";
else
    $link = "http";

// Here append the common URL characters.
$link .= "://";

// Append the host(domain name, ip) to the URL.
$link .= $_SERVER['HTTP_HOST'];

// Append the requested resource location to the URL
$link .= $_SERVER['REQUEST_URI'];

$hostLength  = strlen($link);

if($hostLength > 4) {
    $phpExtension = substr($link, $hostLength - 4, $hostLength);

    if(strcmp($phpExtension, ".php") == 0){
        $headerLocationNew =  substr($link, 0, $hostLength - 4);

        header('Location: '.$headerLocationNew);
    }
    echo $phpExtension;
}

/*$hosts = array(
    'sigudang.appspot.com',
    'http://sigudang.appspot.com/',
    'https://sigudang.appspot.com/',
    'www.sigudang.com',
    'http://www.sigudang.com/',
    'https://www.sigudang.com/',
);

if (in_array($host, $hosts)) {
    header('Location: https://sigudang.com/');
}

session_start();

if( isset($_SESSION['user_id']) ){
	header("Location: /");
}*/

require 'database.php';

if(!empty($_POST['email']) && !empty($_POST['password'])):
	
	$records = $conn->prepare('SELECT id,email,password FROM users WHERE email = :email');
	$records->bindParam(':email', $_POST['email']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	$message = '';

	if(count($results) > 0 && password_verify($_POST['password'], $results['password']) ){

		$_SESSION['user_id'] = $results['id'];
		header("Location: /");

	} else {
		$message = 'Sorry, those credentials do not match';
	}

endif;

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Below</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
</head>
<body>

	<div class="header">
		<a href="/">Your App Name</a>
	</div>

	<?php if(!empty($message)): ?>
		<p><?= $message ?></p>
	<?php endif; ?>

	<h1>Login</h1>
	<span>or <a href="register">register here</a></span>

	<form action="login.php" method="POST">
		
		<input type="text" placeholder="Enter your email" name="email">
		<input type="password" placeholder="and password" name="password">

		<input type="submit">

	</form>

</body>
</html>
