<?php
include "connection.php";
include "session-check.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn-submit'])) {

    $classname = $_POST["quizName"];

    if (isset($_SESSION["teacherid"])) {
        $teacherid = $_SESSION["teacherid"];

        $sql_insert_class = "INSERT INTO tblclass (teacherid, classname) VALUES ('$teacherid', '$classname')";

        if (mysqli_query($connection, $sql_insert_class)) {
            $classid = mysqli_insert_id($connection);
            echo "Your class has been created, and Your Class Code is " . $classid;
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error: Teacher ID not found in session.";
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Create Quiz</title>

		<link rel="stylesheet" href="../css/teacher-createClassroom.css" />
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
			<a href="../html/teacher-teacherDashboard.html">
				<i class="bx bx-left-arrow-alt"></i>
			</a>
			<div class="container">
				<h1>Create Classroom</h1>
				<div class="input-area">
					<form action="#" method="post">
						<input
							type="text"
							name="quizName"
							id="quizName"
							placeholder="Enter Classroom Name"
							required
						/>
						<div class="btn">
							<button type="submit" class="btn-submit" name="btn-submit">
								Create
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
