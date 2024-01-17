<?php
session_start();
include "connection.php";
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

			// Query to fetch quiz information along with the class name
			$query = "SELECT q.quizid, q.quizname, q.creationdate, c.classname 
					FROM tblquiz q
					JOIN tblclass c ON q.classid = c.classid
					WHERE q.classid = ?"; 

			// Prepare the statement to prevent SQL injection
			if ($stmt = mysqli_prepare($connection, $query)) {
				
				// Bind the teacher ID to the statement
				mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacherid']); // can do filter feature here

				// Execute the query
				mysqli_stmt_execute($stmt);

				// Bind the result variables
				mysqli_stmt_bind_result($stmt, $quizid, $quizname, $creationdate, $classname);

				// Fetch the values
				while (mysqli_stmt_fetch($stmt)) {
					echo '<div class="quiz">
							<div class="quiz-info">
								<h3>' . htmlspecialchars($quizname) . '</h3>
								<h4>' . htmlspecialchars($classname) . '</h4>
							</div>
							<div class="view-button">
								<a href="../html/student-quizDesc.html?quizid=' . urlencode($quizid) . '">
									<button type="button">View</button>
								</a>
							</div>
						</div>';
				}

				// Close the statement
				mysqli_stmt_close($stmt);
			} else {
				echo '<p>Unable to fetch quizzes.</p>';
			}

			// Close the database connection
			mysqli_close($connection);
			?>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>