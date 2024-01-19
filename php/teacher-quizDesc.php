<?php
session_start();
include "connection.php";  
include "session-check.php";

if ($_SESSION['role'] == 'teacher') {
    $teacherid = $_SESSION['teacherid'];

    $quiz_query = "SELECT * FROM tblquiz WHERE teacherid = '$teacherid'";
    $quiz_result = mysqli_query($connection, $quiz_query);

    if ($quiz_result) {
        $quiz_data = mysqli_fetch_assoc($quiz_result);

        $className = $quiz_data['quizname'];
        $creationDate = $quiz_data['creationdate'];

        echo <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
	<div class="banner">
		<!--navigation bar-->
			<div class="navbar">
				<a href="../html/teacher-teacherDashboard.html">
					<img src="../picture/logo.png" class="logo" />
				</a>
				<ul>
					<li><a href="../html/teacher-viewQuiz.html">Quiz</a></li>
					<li>
						<a href="../html/teacher-viewLearning.html"
							>Learning Material</a
						>
					</li>
					<li>
						<a href="../html/teacher-progressTracker.html"
							>Performance Monitoring</a
						>
					</li>
					<li>
						<span class="no-a">
							Other Pages<i class="bx bxs-chevron-down"></i>
						</span>
						<div class="sub-menu">
							<ul>
								<li>
									<a href="../html/teacher-aboutUs.html"
										>About Us</a
									>
								</li>
								<li><a href="#">Educational Regulation</a></li>
								<li><a href="#">Data Privacy Law</a></li>
							</ul>
						</div>
					</li>
					<li>
						<span class="no-a">
							Wilson<i class="bx bxs-chevron-down"></i>
						</span>
						<div class="sub-menu">
							<ul>
								<li><a href="#">Profile</a></li>
								<li><a href="#">Log Out</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>

    <div class="main">
        <h1>Quiz 1</h1>
        <div class="quiz-info">
            <table>
                <tr>
                    <th>Quiz Assigned To</th>
                    <td>$className</td>
                </tr>
                <tr>
                    <th>Creation Date</th>
                    <td>$creationDate</td>
                </tr>
                <tr>
                    <th>Marks</th>
                    <td>-</td>
                </tr>
            </table>
        </div>
        <div class="quiz-button">
            <div class="back-button">
                <a href="../../php/teacher-viewQuiz.php">
                    <button>Back</button>
                </a>
            </div>
            <div class="start-button">
                <button type="submit">Delete</button>
            </div>
        </div>
    </div>
</body>
</html>
HTML;
    } else {
        echo "Failed to fetch quiz details. Please try again.";
    }
} else {
    echo "Teacher is not logged in. Please log in first.";
}
?>


<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Quiz</title>

		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />
		<link rel="stylesheet" href="../css/teacher-quizDesc.css" />

		<link
			href="https://fonts.googleapis.com/css2?family=Lemon&display=swap"
			rel="stylesheet"
		/>

		<script src="../javascript/backBtnLogic.js"></script>
	</head>
	<body>
		<!-- copyright part -->
		<?php include '../php/z-user-copyright.php'; ?>
	</body>
</html>
