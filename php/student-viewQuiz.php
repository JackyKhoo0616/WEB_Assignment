<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quizzes</title>

    <link rel="stylesheet" href="../css/student-viewQuiz.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <!-- quiz -->
    <div class="quizpage-wrapper">
        <div class="header">
            <h1>Quiz</h1>
        </div>
        <div class="quizpage-container">

            <?php
			$studentId = $_SESSION['studentid'];

			// step 2: create the sql commands
			$query = "SELECT q.quizid, q.quizname, c.classname, q.creationdate 
					FROM tblquiz q
					INNER JOIN tblenrollment e ON q.classid = e.classid
					INNER JOIN tblclass c ON q.classid = c.classid
					WHERE e.studentid = '{$studentId}'
					ORDER BY q.creationdate DESC";

			// Step 3: Execute the query
			$result = mysqli_query($connection, $query);

			// Step 4: Read the results
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo
					'<div class="quiz">
						<div class="quiz-info">
							<h3>' . htmlspecialchars($row['quizname']) . '</h3>
							<h4>' . htmlspecialchars($row['classname']) . '</h4>
						</div>
						<div class="view-button">
							<a href="../php/student-quizDesc.php?quizid=' . urlencode($row['quizid']) . '">
								<button type="submit">View</button>
							</a>
						</div>
					</div>';
				}
			} else {
				// If no quizzes are found, show the message
				echo 
				'<div class="quiz">
					<div class="quiz-info">
						<h3>No quizzes available at the moment.</h3>
					</div>
				</div>';
			}

			// Step 5: Close the connection
			mysqli_close($connection);
			?>

        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>

</body>

</html>