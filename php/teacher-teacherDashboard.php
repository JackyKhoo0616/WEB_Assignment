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
		<div class="banner">
			<div class="navbar">
				<a href="#">
					<img src="../picture/logo.png" class="logo" />
				</a>
				<ul>
					<li><a href="teacher-viewQuiz.php">Quiz</a></li>
					<li>
						<a href="teacher-viewLearning.php"
							>Learning Material</a
						>
					</li>
					<li>
						<a href="../php/teacher-progressTracker.php"
							>Progress Tracker</a
						>
					</li>
					<li>
						<a href="#"
							>Other Pages<i class="bx bxs-chevron-down"></i
						></a>

						<div class="sub-menu">
							<ul>
								<li>
									<a href="../php/user-aboutUs.php">About Us</a>
								</li>
								<li><a href="../php/user-eduRegulation.php">Educational Regulation</a></li>
								<li><a href="../php/user-dataPrivacy.php">Data Privacy Law</a></li>
							</ul>
						</div>
					</li>
					<li>
						<a href="#"
							>Raiden<i class="bx bxs-chevron-down"></i
						></a>

						<div class="sub-menu">
							<ul>
								<li><a href="#">Profile</a></li>
								<li><a href="../php/logout.php">Log Out</a></li>
							</ul>
						</div>
					</li>
				</ul>
			</div>
		</div>

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
		<div class="footer">
			<div class="left">
				<div class="desc">
					<h2>BreezeQuiz</h2>
					<p>
						BreezeQuiz is an interactive quiz platform enhancing
						learning with gamification, real-time analytics, and a
						resource library for students and educators to improve
						engagement and performance.
					</p>
				</div>
			</div>
			<div class="right">
				<div class="footer-logo">
					<a href="../html/user-index.html" target="_blank">
						<img src="../picture/logo.png" />
					</a>
				</div>
				<div class="contact">
					<p>
						<span class="contact-span1">Email:</span>
						breezequiz@gmail.com
					</p>
					<p>
						<span class="contact-span2">Phone:</span> 09 - 523 -
						2288
					</p>
				</div>
				<div class="social_media">
					<div class="social_media_icons">
						<div class="facebook">
							<a href="https://www.facebook.com/">
								<img src="../picture/facebook.svg" />
							</a>
						</div>
						<div class="instagram">
							<a href="https://www.instagram.com/">
								<img src="../picture/instagram.svg" />
							</a>
						</div>
						<div class="twitter">
							<a href="https://twitter.com/home">
								<img src="../picture/twitter.svg" />
							</a>
						</div>
						<div class="github">
							<a href="https://github.com/">
								<img src="../picture/github.svg" />
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
