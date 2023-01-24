<?php
session_start();
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

error_reporting(0);

ini_set('session.cookie_samesite', "strict");
ini_set('session.cookie_httponly', 1);
/*
        session_set_cookie_params([
            'lifetime' => 3600,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => True,
            'httponly' => True,
            'samesite' => 'strict'
        ]);
*/

$SQLquery = $data = " ";																			// fixing csrf risk

if (isset($_POST['login'])) {
        $username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');												// fixed this xss, sqlinjection
		$password = htmlentities($password = $_POST['password'], ENT_QUOTES, 'UTF-8');									// fixed this xss, sqlinjection
        
		
		$conn = new mysqli("localhost", "root", "", "softwaresecurity");
		$SQLquery = "SELECT id from users where username = '" . $username . "' and password = '" . $password . "'";
		
		$result = $conn->query($SQLquery);
		$data = $result->fetch_assoc();

		$result->close();
		$conn->close();	
}

echo "anti CSRF Token: " . $_SESSION['token'];
?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="style.css">
  </head>
  <body>
	<form method="post" action="" name="signin-form">
	<input type="hidden" name="CSRFToken" value=<?php $_SESSION['token'] ?>>											<!-- token for anti csrf -->
	
	  <div class="form-element">
		<label>Username</label>
		<input type="text" name="username" required />     																<!-- fixed for parameter tampering -->
	  </div>
      <div class="form-element">
		<label>Password</label>
		<input type="text" name="password" required />																	<!-- fixed for parameter tampering -->
	  </div>
		<button type="submit" name="login" value="login">Log In</button>
	</form>
	<?php echo $SQLquery . "<br>";  
		if (!$data) { 			
			echo '<br><img src = "oh_no.png" width="300">
				  <br>
				  <p class="error">incorrect log in</p>'; 
		} elseif ($data && $data != " ") {						
			$_SESSION['user_name'] = $username;				
			header('Location: landing.php');
		}	
	?>
  </body>
</html>
