<?php
include "session-check.php";
include "connection.php";

if (isset($_POST['btn-submit'])) {
    
    if (isset($_SESSION['teacherid'])) {
        $teacherid = $_SESSION['teacherid'];

        $classid = $_POST['classid'];
        
        $query = "SELECT * FROM tblclass WHERE teacherid = '$teacherid' AND classid = '$classid'";

        $result = mysqli_query($connection, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $studentid = $_POST['studentid'];
            $enroll_query = "INSERT INTO tblenrollment (studentid, classid) VALUES ('$studentid', '$classid')";
            $enroll_result = mysqli_query($connection, $enroll_query);

            if ($enroll_result) {
                echo "Successfully Enrolled";
            } else {
                echo "Failed to Enroll";
            }
        } else {
            echo "You don't have permission to enroll in this class.";
        }
    } else {
        echo "User is not logged in. Please log in first.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Dashboard</title>
		<link
			href="https://fonts.googleapis.com/css2?family=Lemon&display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />
		<link rel="stylesheet" href="../css/teacher-teacherDashboard.css" />
	</head>
	<body>
		<!-- navigational bar -->
		<?php include "z-teacher-nav.php"; ?>

		<!-- top part -->
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
					<input
						type="text"
						name="studentid"
						placeholder="Enter Student ID"
						required
					/>
				</div>
				<div class="search-container">
					<i class="bx bx-search"></i>
					<input
						type="text"
						name="classid"
						placeholder="Enter Class Code"
						required
					/>
				</div>
				<div class="button-container">
					<button type="btn-submit" name="btn-submit">Add Student</button>
				</div>
			</form>
		</div>

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
				<a href="teacher-createClassroom.php">
					<button>Create Classroom</button>
				</a>
				<a href="teacher-viewClassroom.php">
					<button>View All Classroom</button>
				</a>
			</div>
		</div>

		<!-- Progress Tracker -->
		<div class="tracker-wrapper">
			<h2>Progress Tracker</h2>
			<div class="progress">
				<table>
					<tr>
						<th class="student-id">Student ID</th>
						<th class="student-name">Student Name</th>
						<th class="class-code">Class Code</th>
						<th class="quiz-name">Quiz Name</th>
						<th class="status">Status</th>
					</tr>
					<tr>
						<td>tp069263</td>
						<td>Yow Li Geng</td>
						<td>123456</td>
						<td>Quiz 1</td>
						<td>Completed</td>
					</tr>
					<tr>
						<td>tp069263</td>
						<td>Yow Li Geng</td>
						<td>123456</td>
						<td>Quiz 2</td>
						<td>Completed</td>
					</tr>
					<tr>
						<td>tp069263</td>
						<td>Yow Li Geng</td>
						<td>123456</td>
						<td>Quiz 3</td>
						<td>No Attempted</td>
					</tr>
				</table>
				</div>
			<div class="view-more">
				<a href="../html/teacher-progressTracker.html">
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
