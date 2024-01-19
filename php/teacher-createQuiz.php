<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

if (isset($_POST['btn-submit'])) {
    $quizname = $_POST['quizName'];
    $classid = $_POST['classCode'];
    $teacherid = $_SESSION['teacherid'];
    $creationdate = date("Y-m-d H:i:s");

    $insertQuizQuery = "INSERT INTO tblquiz (teacherid, classid, quizname, creationdate) VALUES ('$teacherid', '$classid', '$quizname', '$creationdate')";
    mysqli_query($connection, $insertQuizQuery);

    $quizid = mysqli_insert_id($connection);

    $questionIndex = 1;
    while (isset($_POST["question$questionIndex"])) {
        $question = $_POST["question$questionIndex"];
        $choicea = $_POST["option$questionIndex-A"];
        $choiceb = $_POST["option$questionIndex-B"];
        $choicec = $_POST["option$questionIndex-C"];
        $choiced = $_POST["option$questionIndex-D"];
        $answer = $_POST["correctAnswer$questionIndex"];

        $insertQuestionQuery = "INSERT INTO tblquestion (quizid, question, choicea, choiceb, choicec, choiced, answer) VALUES ('$quizid', '$question', '$choicea', '$choiceb', '$choicec', '$choiced', '$answer')";
        mysqli_query($connection, $insertQuestionQuery);

        $questionIndex++;
    }

    echo "Quiz created successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Create Quiz</title>

		<link rel="stylesheet" href="../css/teacher-createQuiz.css" />
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />

		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Lemon&display=swap"
			rel="stylesheet"
		/>
	</head>
	<script src="../javascript/createQuiz.js"></script>

	<body>
		<!-- content -->
		<div class="main-wrapper">
			<h1>Create A Quiz</h1>
			<div class="input-area">
				<form action="#" method="post">
					<label for="quizName">Quiz Name</label>
					<input
						type="text"
						name="quizName"
						id="quizName"
						placeholder="Enter Quiz Name"
						required
					/>
					<label for="classCode">Class Code</label>
					<input
						type="text"
						name="classCode"
						id="classCode"
						placeholder="Enter Class Code"
						required
					/>
					<div id="questions">
						<div class="question">
							<label for="question1">Question 1</label>
							<input
								type="text"
								name="question1"
								id="question1"
								placeholder="Enter The Question"
								required
							/>

							<div class="options">
								<div class="option">
									<label for="option1-A">Option A</label>
									<input
										type="text"
										name="option1-A"
										id="option1-A"
										placeholder="Enter Option 1"
										required
									/>
								</div>
								<div class="option">
									<label for="option1-B">Option B</label>
									<input
										type="text"
										name="option1-B"
										id="option1-B"
										placeholder="Enter Option 2"
										required
									/>
								</div>
								<div class="option">
									<label for="option1-C">Option C</label>
									<input
										type="text"
										name="option1-C"
										id="option1-C"
										placeholder="Enter Option 3"
										required
									/>
								</div>
								<div class="option">
									<label for="option1-D">Option D</label>
									<input
										type="text"
										name="option1-D"
										id="option1-D"
										placeholder="Enter Option 4"
										required
									/>
								</div>
							</div>

							<label for="correctAnswer1">Correct Answer</label>
							<select name="correctAnswer1" id="correctAnswer1">
								<option value="option1-A">Option A</option>
								<option value="option1-B">Option B</option>
								<option value="option1-C">Option C</option>
								<option value="option1-D">Option D</option>
							</select>
							<div
								class="delete-icon"
								data-tooltip="Delete Question"
							>
								<a href="">
									<i class="bx bx-message-square-x"></i>
								</a>
							</div>
						</div>
					</div>

					<div class="btn">
						<button type="button" id="addQuestion">
							Add Question
						</button>
						<a href="">
							<button type="submit" class="btn-submit" name="btn-submit">Create Quiz</button>
						</a>
					</div>
				</form>
			</div>
		</div>
		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
