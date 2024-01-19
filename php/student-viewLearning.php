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

    <link rel="stylesheet" href="../css/student-viewLearning.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <!-- learning material -->
    <div class="learningpage-wrapper">
        <div class="header">
            <h1>Learning Material</h1>
        </div>
        <div class="learningpage-container">

            <?php

			// get the student ID from the session
			$studentId = $_SESSION['studentid'];

			// Query to get learning materials for enrolled classes
			$query = "SELECT lm.lmid, lm.lmname, c.classname 
					FROM tbllm lm
					INNER JOIN tblclass c ON lm.classid = c.classid
					INNER JOIN tblenrollment e ON c.classid = e.classid
					WHERE e.studentid = ?
					ORDER BY lm.creationdate ASC";

			if ($stmt = mysqli_prepare($connection, $query)) {
				// Bind the student ID to the prepared statement
				mysqli_stmt_bind_param($stmt, "i", $studentId);

				// Execute the query
				mysqli_stmt_execute($stmt);

				// Bind the result variables
				mysqli_stmt_bind_result($stmt, $lmId, $lmName, $className);

				// Fetch the results
				while (mysqli_stmt_fetch($stmt)) {
					echo "<div class='learning'>
							<div class='learning-info'>
								<h3>" . htmlspecialchars($lmName) . "</h3>
								<h4>" . htmlspecialchars($className) . "</h4>
							</div>
							<div class='view-button'>
								<a href='../php/student-learningDesc.php?lmid=" . urlencode($lmId) . "' target='_blank'>
									<button type='submit'>View</button>
								</a>
							</div>
						</div>";
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