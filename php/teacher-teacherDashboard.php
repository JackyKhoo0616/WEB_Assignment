<?php
include "connection.php";
include_once "session-check.php";

checkPageAccess(['teacher']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/teacher-teacherDashboard.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>










    <!-- classroom  -->
    <div class="header">
        <div class="img-container">
            <img src="../picture/header_teacher.png" />
        </div>
    </div>
    <div class="search">
        <h1>Enroll Student</h1>
        <form action="teacher-teacherDashboard.php" method="post">
            <div class="search-container">
                <i class="bx bx-user-plus"></i>
                <input type="text" name="studentid" placeholder="Enter Student ID" required />
            </div>
            <div class="search-container">
                <i class="bx bx-search"></i>
                <input type="text" name="classid" placeholder="Enter Class Code" required />
            </div>
            <div class="button-container">
                <button type="btn-submit" name="btn-submit">Add Student</button>
            </div>
        </form>
    </div>

    <?php
	include "connection.php";

	if (isset($_POST['btn-submit'])) {
		$studentId = $_POST['studentid'];
		$classId = $_POST['classid'];

		// Verify that the class exists
		$classQuery = "SELECT * FROM tblclass WHERE classid = '{$classId}'";
		$classResult = mysqli_query($connection, $classQuery);
		if (mysqli_num_rows($classResult) == 0) {

			// Class does not exist
			echo "<script>alert('The class does not exist.');</script>";
			mysqli_close($connection);
			exit;
		}

		// Check if the enrollment already exists
		$checkEnrollmentQuery = "SELECT * FROM tblenrollment WHERE studentid = '{$studentId}' AND classid = '{$classId}'";
		$checkEnrollmentResult = mysqli_query($connection, $checkEnrollmentQuery);
		if (mysqli_num_rows($checkEnrollmentResult) > 0) {
			
			// The student is already enrolled in this class
			echo "<script>alert('The student is already enrolled in this class.');</script>";
			
		} else {
			// Enroll the student in the class
			$enrollQuery = "INSERT INTO tblenrollment (studentid, classid) VALUES ('{$studentId}', '{$classId}')";
			if (mysqli_query($connection, $enrollQuery)) {
				
				// Enrollment was successful
				echo "<script>alert('Student enrolled successfully.');</script>";
				
			} else {
				// There was an error enrolling the student
				echo "<script>alert('Error enrolling student.');</script>";
			}
		}

		// Close the connection
		mysqli_close($connection);
	}
	?>










    <!-- content -->
    <div class="wrapper">
        <h2>Teacher Function</h2>
        <div class="function">
            <a href="teacher-createQuiz.php" target="_blank">
                <button>Create Quiz</button>
            </a>
            <a href="teacher-createLearning.php" target="_blank">
                <button>Create Learning Material</button>
            </a>
        </div>
        <div class="function-additional">
            <a href="teacher-createClassroom.php" target="_blank">
                <button>Create Classroom</button>
            </a>
            <a href="teacher-viewClassroom.php" target="_blank">
                <button>View All Classroom</button>
            </a>
        </div>
    </div>












    <!-- Progress Tracker -->
    <div class="tracker-wrapper">
        <h2>Performance Monitoring</h2>
        <div class="progress">
            <table>
                <tr>
                    <th class="student-id">Student ID</th>
                    <th class="student-name">Student Name</th>
                    <th class="class-code">Class Code</th>
                    <th class="quiz-name">Quiz Name</th>
                    <th class="status">Status</th>
                    <th class="marks">Marks</th>
                    <th class="date">Date Attempt</th>
                </tr>

                <?php
				include "connection.php";
				
				$teacherId = $_SESSION['teacherid'];

				// step 2: create the sql commands
				$query = "SELECT s.studentid, s.fname, s.lname, c.classname, q.quizname, p.status, p.marks, p.attemptdate
						FROM tblprogress p
						INNER JOIN tblquiz q ON p.quizid = q.quizid
						INNER JOIN tblclass c ON q.classid = c.classid
						INNER JOIN tblstudents s ON p.studentid = s.studentid
						WHERE c.teacherid = '{$teacherId}'
						ORDER BY p.attemptdate DESC, q.creationdate DESC
						LIMIT 5";

				// Step 3: Execute the query
				$result = mysqli_query($connection, $query);

				// Step 4: Read the results
				if (mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						// Check if the status is 'No Attempt', if so, set marks and date to '-'
						$displayMarks = $row['status'] === 'No Attempt' ? '-' : htmlspecialchars($row['marks']);
						$displayDate = $row['status'] === 'No Attempt' ? '-' : htmlspecialchars(date('Y-m-d', strtotime($row['attemptdate'])));

						echo '<tr>
								<td>' . htmlspecialchars($row['studentid']) . '</td>
								<td>' . htmlspecialchars($row['fname']) . ' ' . htmlspecialchars($row['lname']) . '</td>
								<td>' . htmlspecialchars($row['classname']) . '</td>
								<td>' . htmlspecialchars($row['quizname']) . '</td>
								<td>' . htmlspecialchars($row['status']) . '</td>
								<td>' . $displayMarks . '</td>
								<td>' . $displayDate . '</td>
							</tr>';
					}
				} else {
					echo '<tr><td colspan="7">No progress records found.</td></tr>';
				}

				// Step 5: Close the connection
				mysqli_close($connection);
				?>

            </table>
        </div>
        <div class="view-more">
            <a href="../php/teacher-progressTracker.php">
                <button>
                    View More<i class="bx bx-right-arrow-alt"></i>
                </button>
            </a>
        </div>
    </div>











    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>