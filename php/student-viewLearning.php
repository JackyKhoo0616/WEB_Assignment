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
    <title>Learning Materials</title>

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
			// get the student ID from the session
			$studentId = $_SESSION['studentid'];

			// Step 2: create the sql commands
			$query = "SELECT lm.lmid, lm.lmname, lm.creationdate, c.classname 
					FROM tbllm lm
					INNER JOIN tblenrollment e ON lm.classid = e.classid
					INNER JOIN tblclass c ON lm.classid = c.classid
					WHERE e.studentid = '{$studentId}'
					ORDER BY lm.creationdate DESC";

			// Step 3: Execute the query
			$result = mysqli_query($connection, $query);

			// Step 4: Read the results
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<div class="learning">
							<div class="learning-info">
								<h3>' . htmlspecialchars($row['lmname']) . '</h3>
								<h4>' . htmlspecialchars($row['classname']) . '</h4>
							</div>
							<div class="view-button">
								<a href="../php/student-learning.php?lmid=' . urlencode($row['lmid']) . '" target="_blank">
									<button type="button">View</button>
								</a>
							</div>
						</div>';
				}   

			} else {
				// If no learning materials are found, show the message
				echo '<div class="learning-material">
						<div class="learning-info">
							<h3>No learning materials available at the moment.</h3>
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