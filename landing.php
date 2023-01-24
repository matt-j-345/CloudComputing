<?php
session_start();

if (isset($_POST['add_comment'])) {
        $comment = $_POST['comment'];
		
		$conn = new mysqli("localhost", "root", "", "softwaresecurity");
		$SQLquery = "INSERT INTO guestbook (username, comment) VALUES ('" . $_SESSION['user_name'] . "', '" . $comment . "')";
		$conn->query($SQLquery);
		$conn->close();
	}
	
	if (!isset($_SESSION['user_name'])) { 																		
		echo '<center><img src = "oh_no.png"><br>You are not logged in!</center>';
	} else {
		echo "<h1>Nice to see you again, " . ucfirst($_SESSION['user_name']) . "!</h1>";
		echo "<a href='logout.php'>logout</a>"
 ?>
		<!DOCTYPE html>
		<html>
			<head>
				<link rel="stylesheet" href="style.css">
			</head>
			<body>
				<form method="post" action="" name="guestbook">
					<div class="form-element">
						<label>Guest Book</label>
						<textarea name="comment" id="guestbook" rows="6" cols="50">Leave something nice here...</textarea>
					</div>
				</div>
					<button type="submit" name="add_comment" value="add_comment">Add Comment</button>
				</form>
			</body>
		</html>

<?PHP
	$conn = new mysqli("localhost", "root", "", "softwaresecurity");
	$query = "SELECT * FROM guestbook"; 																				
	$result = $conn->query($query);

	echo "<center><table class='styled-table'>"; 

		while($row = $result->fetch_assoc()){ 
			echo "<tr><td>" . date_format(new DateTime($row['timestamp']), 'g:ia \o\n l jS F Y') . "</td><td>" 
			. ucfirst($row['username']) . "</td><td>" . $row['comment'] ."</td></tr>"; 
		}

		echo "</table></center>"; 	
	}	
?>
