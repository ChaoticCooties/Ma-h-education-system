<!DOCTYPE html>
<html>
<head>
	<title>Lesson</title>
	<link rel="stylesheet" type="text/css" href="../css/lesson.css">
</head>
<body>
	<div class="title">
		<strong><?php echo $title; ?></strong>
	</div>
	<div class="lesson">
		<strong>Lesson</strong>
		<div class="content">
			<?php echo $lessonText; ?>
		</div>
	</div>
	<div class="practice">
		<strong>Practice</strong>
		<div class="content">
			<form>
			</form>
			<div class="result">
			</div>
			<form method="post" action="lesson.php">
				<input type="submit" name="submit" value="Proceed to next lesson" id="submit" disabled="disabled"></input>
			</form>
		</div>
	</div>
	<script>
		var form = document.forms[0];
		var array = [];

		<?php
			for ($i = 0; $i < 10; $i++) {
				echo "question(\"" . $arrayQuiz[$i][0] . " = \");";
				echo "input(\"" . $arrayQuiz[$i][1] . "\");";
			}
		?>

		form.appendChild(document.createElement("br"));

		var button = document.createElement("input");
		button.type = "button";
		button.setAttribute("onClick", "check()");
		button.value = "Check answers";
		form.appendChild(button);
		//---------------------------
		//display a title in form
		function question(name) {
			var title = document.createTextNode(name);
			form.appendChild(title);
		}
		//display input textfield in form
		function input(name) {
			var input = document.createElement("input");
			input.type = "number";
			input.name = name;
			input.setAttribute("class", "answers");
			form.appendChild(input);
			form.appendChild(document.createElement("br"));
		}

		function check() {
			var result = 0;
			array = document.getElementsByClassName("answers");
			for (var i = 0; i < array.length; i++) {
				if (array[i].value == array[i].name) {
					result += 1;
				}
			}
			result = result / array.length * 100;
			document.getElementsByClassName("result")[0].innerHTML = result + "%";
			if (result >= 80) {
				document.getElementsByClassName("result")[0].innerHTML += " - Congratulations";
				document.getElementById("submit").disabled = false;
			} else {
				document.getElementsByClassName("result")[0].innerHTML += " - You need over 80% to proceed";
			}
		}
	</script>
</body>
</html>
