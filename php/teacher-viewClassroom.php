<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Progress Tracker</title>

		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />
		<link rel="stylesheet" href="../css/teacher-viewClassroom.css" />

		<link
			href="https://fonts.googleapis.com/css2?family=Lemon&display=swap"
			rel="stylesheet"
		/>
		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
	</head>
	<body>
		<!-- navigational bar -->
		<div class="banner">
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

		<!-- content -->
		<div class="wrapper">
			<div class="header">
				<h1>View Classroom</h1>
			</div>
			<div class="filter-section">
				<h2>Search by:</h2>
				<div class="filter">
					<form action="">
						<h3>Class Code:</h3>
						<input
							type="text"
							name="studentID"
							id="studentID"
							placeholder="Enter Class Code"
						/>
						<div class="button-container">
							<button type="submit">Search</button>
						</div>
					</form>
				</div>
			</div>

			<div class="details">
				<h2>Classroom Details:</h2>
				<div class="details-container">
					<div class="details-left">
						<h3>Class Code:</h3>
						<h3>Class Name:</h3>
					</div>
					<div class="details-right">
						<h3>123456</h3>
						<h3>Mathematics</h3>
					</div>
				</div>
			</div>
			<div class="tablelist">
				<table>
					<tr>
						<th class="student-id">Student ID</th>
						<th class="student-name">Student Name</th>
						<th class="email">Email</th>
						<th class="dob">Date of Born</th>
						<th class="country">Country</th>
						<th class="gender">Gender</th>
					</tr>
					<tr>
						<td>123456</td>
						<td>Wilson</td>
						<td>wilsonchunkeat29@gmail.com</td>
						<td>29/11/2000</td>
						<td>Malaysia</td>
						<td>Male</td>
					</tr>
				</table>
			</div>
		</div>

		<!-- copyright part -->
		<?php include '../php/z-user-copyright.php'; ?>
	</body>
</html>
