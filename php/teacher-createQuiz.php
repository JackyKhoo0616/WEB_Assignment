<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);
?>

<?php
if (isset($_POST['btnCreateQuiz'])) {
    // Assuming $connection is your database connection
    $quizname = $_POST['quizname'];
    $creationdate = date("Y-m-d H:i:s"); // Current date and time
    $teacherid = $_SESSION['teacherid']; // Assuming you have a teacher session after login

    // Insert quiz details into tblquiz
    $insertQuizQuery = "INSERT INTO tblquiz (quizname, creationdate, teacherid) VALUES ('$quizname', '$creationdate', '$teacherid')";
    mysqli_query($connection, $insertQuizQuery);

    // Retrieve the autogenerated quizid
    $quizid = mysqli_insert_id($connection);

    // Loop through each question submitted in the form
    foreach ($_POST['questions'] as $questionData) {
        $question = $questionData['question'];
        $choicea = $questionData['choicea'];
        $choiceb = $questionData['choiceb'];
        $choicec = $questionData['choicec'];
        $choiced = $questionData['choiced'];
        $correctAnswer = $questionData['correctAnswer'];

        // Insert question details into tblquestion
        $insertQuestionQuery = "INSERT INTO tblquestion (question, choicea, choiceb, choicec, choiced, quizid) VALUES ('$question', '$choicea', '$choiceb', '$choicec', '$choiced', '$quizid')";
        mysqli_query($connection, $insertQuestionQuery);

        // Update the correct answer based on the questionnum (autogenerated primary key)
        $updateAnswerQuery = "UPDATE tblquestion SET answer = '$correctAnswer' WHERE quizid = '$quizid' AND questionnum = LAST_INSERT_ID()";
        mysqli_query($connection, $updateAnswerQuery);
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
							<button type="submit">Create Quiz</button>
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
