<?php
//only login
//only admin

/* Connect to database */
$conn = mysqli_connect('localhost','root','','sdp');
/* Checks for error */
if(mysqli_connect_errno()) {
	die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
}

$id = $_GET["id"];
$sql = "SELECT f.subject, f.message, u.username FROM feedback f LEFT JOIN users u ON f.headmasterID = u.id WHERE f.id = $id;";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html>
<head>
	<title>View Feedback</title>
	<link rel="stylesheet" type="text/css" href="../css/viewfeedback.css">
</head>
<body>
	<div class="title">
		Feedback
	</div>
	<div class="container">
		<div class="lbl">NAME</div>
		<div class="name">
			<?php echo $row["username"]; ?>
		</div>
		<div class="lbl">SUBJECT</div>
		<div class="subject">
			<?php echo $row["subject"]; ?>
		</div>
		<div class="lbl">MESSAGE</div>
		<div class="message">
			<?php echo $row["message"]; ?>
		</div>
	</div>
</body>
</html>
