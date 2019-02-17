<!DOCTYPE html>
<html>
<head>
	<title>Placement Test</title>
	<link rel="stylesheet" type="text/css" href="../css/placement.css">
</head>
<body>
	<div class="main">
		<div class="title">
			Placement Test
		</div>
		<div class="qcontainer">
			<div class="question">
				<?php echo $_SESSION["placementQ"][0]; ?>
			</div>
		</div>
		<div class="answers">
			<div class="answerA">
				<form action="placement.php" method="post">
					A
					<button type="submit" name="answer" value="<?php echo $_SESSION["placementQ"][2]; ?>">
						<?php echo $_SESSION["placementQ"][2]; ?>
					</button>
				</form>
			</div>
			<div class="answerB">
				<form action="placement.php" method="post">
					B
					<button type="submit" name="answer" value="<?php echo $_SESSION["placementQ"][3]; ?>">
						<?php echo $_SESSION["placementQ"][3]; ?>
					</button>
				</form>
			</div>
			<div class="answerC">
				<form action="placement.php" method="post">
					C
					<button type="submit" name="answer" value="<?php echo $_SESSION["placementQ"][4]; ?>">
						<?php echo $_SESSION["placementQ"][4]; ?>
					</button>
				</form>
			</div>
			<div class="answerD">
				<form action="placement.php" method="post">
					D
					<button type="submit" name="answer" value="<?php echo $_SESSION["placementQ"][5]; ?>">
						<?php echo $_SESSION["placementQ"][5]; ?>
					</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
