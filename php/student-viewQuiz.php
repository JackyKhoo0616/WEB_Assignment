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

			// get the student ID from the session
			$studentId = $_SESSION['studentid'];

			// Query to get quizzes for enrolled classes
			$query = "SELECT q.quizid, q.quizname, c.classname, q.creationdate
					FROM tblquiz q
					INNER JOIN tblenrollment e ON q.classid = e.classid
					INNER JOIN tblclass c ON q.classid = c.classid
					WHERE e.studentid = ?
					ORDER BY q.creationdate ASC";

			if ($stmt = mysqli_prepare($connection, $query)) {
				// Bind the student ID to the prepared statement
				mysqli_stmt_bind_param($stmt, "i", $studentId);

				// Execute the query
				mysqli_stmt_execute($stmt);

				// Store the result so we can check the number of rows
				mysqli_stmt_store_result($stmt);

				// Check if there are any quizzes available
				if (mysqli_stmt_num_rows($stmt) > 0) {
					// Bind the result variables
					mysqli_stmt_bind_result($stmt, $quizId, $quizName, $className, $creationDate);

					// Fetch the results
					while (mysqli_stmt_fetch($stmt)) {
						echo "<div class='quiz'>
								<div class='quiz-info'>
									<h3>" . htmlspecialchars($quizName) . "</h3>
									<h4>" . htmlspecialchars($className) . "</h4>
								</div>
								<div class='view-button'>
									<a href='../html/student-quizDesc.html?quizid=" . urlencode($quizId) . "'>
										<button type='submit'>View</button>
									</a>
								</div>
							</div>";
					}
				} else {
					// If no quizzes are found, show the message
					echo '<div class="quiz">
                                <div class="quiz-info">
                                    <h3>No quizzes available at the moment.</h3>
                                </div>
                            </div>';
				}

				// Close statement
				mysqli_stmt_close($stmt);
				
			} else {
				// SQL error
				echo "SQL Error: " . htmlspecialchars(mysqli_error($connection));
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