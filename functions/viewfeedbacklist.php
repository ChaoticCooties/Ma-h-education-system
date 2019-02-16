<?php

$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}
//ONLY ADMIN

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
	die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$sql = "SELECT f.id, f.subject, u.username FROM feedback f LEFT JOIN users u ON f.teacherID = u.id;";

$result = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Feedback List</title>
	<link rel="stylesheet" type="text/css" href="../css/viewfeedbacklist.css">
</head>
<body>
	<div class="title">
		Feedback List
	</div>
	<div class="container">
		<table id="table" class="table">
			<tr>
				<td class="name"><strong>Name</strong></td>
				<td class="subject"><strong>Subject</strong></td>
			</tr>
			<?php
				if(mysqli_affected_rows($conn) > 0) {
					while($row = mysqli_fetch_assoc($result)) {
						echo "<tr><td class=\"name\">" . $row["username"] . "</td><td class=\"subject\"><a href=\"viewfeedback.php?id=" . $row["id"] . "\">" . $row["subject"] . "</a></td></tr>";
					}
				} else {
					echo "no result";
				}
			?>
		</table>
	</div>
</body>
</html>
