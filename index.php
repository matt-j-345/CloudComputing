<?php
session_start();
$SQLquery = $data = " ";

if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
		
		$conn = new mysqli("localhost", "root", "", "softwaresecurity");
		
		$SQLquery = "SELECT id from users where username = '" . $username . "' and password = '" . $password . "'";
		
		$result = $conn->query($SQLquery);
		$data = $result->fetch_assoc();

		$result->close();
		$conn->close();	
}
?>
<!DOCTYPE html>
<html>
  <head>
	<link rel="stylesheet" href="style.css">
  </head>
  <body>
	<form method="post" action="" name="signin-form">
	  <div class="form-element">
		<label>Username</label>
		<input type="text" name="username"  />
	  </div>
      <div class="form-element">
		<label>Password</label>
		<input type="password" name="password"  />
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
