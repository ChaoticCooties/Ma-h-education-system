<!DOCTYPE html>
<html>
<head>
	<title>Exam</title>
	<link rel="stylesheet" type="text/css" href="../css/exam.css">
</head>
<body>
	<div class="main">
		<div class="title">
			<?php echo $title; ?>
		</div>
		<div class="qcontainer">
			<div class="questionno">
				<?php echo $examArray[$_GET["q"]][0] . ")"; ?>
			</div>
			<div class="question">
				<?php echo $examArray[$_GET["q"]][1]; ?>
			</div>
		</div>
		<div class="answers">
			<div class="answerA">
				<form action="exam.php?q=<?php echo $_GET["q"] + 1; ?>" method="post">
					A
					<button type="submit" name="answer" value="<?php echo $examArray[$_GET["q"]][3]; ?>">
						<?php echo $examArray[$_GET["q"]][3]; ?>
					</button>
				</form>
			</div>
			<div class="answerB">
				<form action="exam.php?q=<?php echo $_GET["q"] + 1; ?>" method="post">
					B
					<button type="submit" name="answer" value="<?php echo $examArray[$_GET["q"]][4]; ?>">
						<?php echo $examArray[$_GET["q"]][4]; ?>
					</button>
				</form>
			</div>
			<div class="answerC">
				<form action="exam.php?q=<?php echo $_GET["q"] + 1; ?>" method="post">
					C
					<button type="submit" name="answer" value="<?php echo $examArray[$_GET["q"]][5]; ?>">
						<?php echo $examArray[$_GET["q"]][5]; ?>
					</button>
				</form>
			</div>
			<div class="answerD">
				<form action="exam.php?q=<?php echo $_GET["q"] + 1; ?>" method="post">
					D
					<button type="submit" name="answer" value="<?php echo $examArray[$_GET["q"]][6]; ?>">
						<?php echo $examArray[$_GET["q"]][6]; ?>
					</button>
				</form>
			</div>
		</div>
	</div>
	<div class="side">
		<div class="selector">
			<?php
			for ($i = 0; $i < count($examArray); $i++) {
				echo "<div><a href=\"exam.php?q=" . $i . "\">Question " . ($i + 1) . "</a></div>";
				echo "Selected: " . $_SESSION["examAns"][$i] . "<br/><br/>";
			}
			?>
		</div>
		<div class="submit">
			<form action="exam.php?q=0" method="post">
				<button type="submit" name="submit" >
						Submit
				</button>
			</form>
		</div>
	</div>
</body>
</html>
