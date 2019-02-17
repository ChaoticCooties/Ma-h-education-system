<?php

require '../core/start.php';
//NEED TO ADD OUTPUT

$user = new User();
if(!$user->isLoggedIn()) {
    Redirect::to('home.php');
}
if (!$user->hasPermission("moderator")) {
	Redirect::to('home.php');
}

if(Input::exists()) {

	$id = $user->data()->id;
	$subject = $_POST["subject"];
	$message = $_POST["message"];
	$datetime = date("Y-m-d H:i:s");

	/* Connect to database */
	$conn = mysqli_connect('localhost','root','','sdp');
	/* Checks for error */
	if(mysqli_connect_errno()) {
		die('<script>alert("Connection failed: Please check your SQL connnection!");</script>');
	}

	$sql = "INSERT INTO feedback (subject,message,datetime,teacherID) VALUES ('$subject','$message','$datetime','$id')";

	mysqli_query($conn, $sql);

	if(mysqli_affected_rows($conn) <=0)
	{
		Session::flash("state", "Failed to send feedback");
	} else {
    Session::flash("state", "Successfully sent feedback");
	}

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Feedback</title>
	<link href="../css/feedback.css" rel="stylesheet">
</head>
<body>
  <div class="message">
    <?php echo Session::flash("state"); ?>
  </div>
	<div class="container">
		<div class="title">Feedback</div>
		<form action="" method="post">
			<div class="lbl">SUBJECT</div>
			<input name="subject" type="text" />
			<br/>
			<p class="lbl">MESSAGE</p>
			<textarea name="message"></textarea>
			<br/><br/>
			<div class="button">
        <a href="profile.php">Back to profile</a>
				<input name="submit" type="submit" />
				<input name="reset" type="reset" />
			</div>
		</form>
	</div>
</body>
</html>
