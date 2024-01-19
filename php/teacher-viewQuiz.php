<?php
include "session-check.php";
include "connection.php";

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Quizzes</title>

		<link rel="stylesheet" href="../css/teacher-viewQuiz.css" />
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />

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
					<li><a href="../php/teacher-viewQuiz.php">Quiz</a></li>
					<li>
						<a href="../php/teacher-viewLearning.php"
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

		<!-- quiz -->
		<div class="quizpage-wrapper">
			<div class="header">
				<h1>Quiz</h1>
				<div class="add-on-btn">
					<a href="../php/teacher-createQuiz.php" target="_blank">
						<button type="submit">Create Quiz</button>
					</a>
				</div>
			</div>
			<div class="quizpage-container">
				<div class="quiz">
					<div class="quiz-info">
						<h3>Quiz 1</h3>
					</div>
					<div class="view-button">
						<a href="teacher-quizDesc.php">
							<button>View</button>
						</a>
					</div>
					<div class="delete-button">
						<button>Delete</button>
					</div>
				</div>
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
