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

    <link rel="stylesheet" href="../css/student-viewLearning.css" />

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
			
			// Query to fetch learning material information along with the class name
			$query = "SELECT lm.lmid, lm.lmname, lm.creationdate, c.classname 
					FROM tbllm lm
					JOIN tblclass c ON lm.classid = c.classid
					WHERE lm.classid = ?";

			// Prepare the statement to prevent SQL injection
			if ($stmt = mysqli_prepare($connection, $query)) {
				
				// Bind the teacher ID to the statement
				mysqli_stmt_bind_param($stmt, "i", $_SESSION['teacherid']); // can do filter feature here

				// Execute the query
				mysqli_stmt_execute($stmt);

				// Store the result so you can get row counts and use other functions
				mysqli_stmt_store_result($stmt);

				// Bind the result variables
				mysqli_stmt_bind_result($stmt, $lmid, $lmname, $creationdate, $classname);

				// Fetch the values
				while (mysqli_stmt_fetch($stmt)) {
					echo '<div class="learning">
							<div class="learning-info">
								<h3>' . htmlspecialchars($lmname) . '</h3>
								<h4>' . htmlspecialchars($classname) . '</h4>
							</div>
							<div class="view-button">
								<a href="../html/student-learning.html?lmid=' . urlencode($lmid) . '" target="_blank">
									<button type="button">View</button>
								</a>
							</div>
						</div>';
				}

				// Close the statement
				mysqli_stmt_close($stmt);
			} else {
				echo '<p>No learning materials available.</p>';
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