<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>BreezeQuiz</title>
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/adminDashboard.css" />
		<link rel="stylesheet" href="../css/footer.css" />
	</head>

	<body>
		<header>
			<!-- navigational bar -->
			<div class="banner">
				<div class="navbar">
					<a href="#">
						<img src="../picture/logo.png" class="logo" />
					</a>
					<ul>
						<li><a href="#">Home</a></li>
						<li>
							<a href="#">Service</a>
							<div class="sub-menu">
								<ul>
									<li><a href="#">Quiz</a></li>
									<li><a href="#">Learning Material</a></li>
								</ul>
							</div>
						</li>
						<li><a href="#">About Us</a></li>
						<li>
							<a href="#">Other Pages</a>
							<div class="sub-menu">
								<ul>
									<li><a href="#">Sign Up</a></li>
									<li>
										<a href="#">Educational Regulation</a>
									</li>
									<li><a href="#">Data Privacy Law</a></li>
								</ul>
							</div>
						</li>
						<button class="login"><a href="#">Login</a></button>
					</ul>
				</div>
			</div>

			<!-- headline & welcome msg -->
			<div class="content">
				<h1>Admin Dashboard</h1>

				<div class="welcome">
					<h2>Welcome back, {adminname}</h2>
				</div>
			</div>

			<div class="data">
				<div class="data1">
					<h3>Total Quizzes</h3>
					<p>600</p>
				</div>

				<div class="data2">
					<h3>Total Learning Module</h3>
					<p>200</p>
				</div>

				<div class="data3">
					<h3>Total Student</h3>
					<p>200</p>
				</div>

				<div class="data4">
					<h3>Total Teacher</h3>
					<p>22</p>
				</div>
			</div>
		</header>

		<main>
			<div class="function-wrapper">
				<h1>Main</h1>

				<div class="image">

				</div>

				<div class="container">

					<a href="#">
						<button class="function">
							<p>Search User Details</p>
						</button>

					<a href="#">
						<button class="function">
							<p>Access All Quiz</p>
						</button>

					<a href="#">
						<button class="function">
							<p>Access All Learning Material</p>
						</button>
					</a>

				</div>
			</div>

			<div class="OtherPages">
				<div class="EducationalRegulation">
					<img src="../picture/regulation_bg.jpg" />
					<h3>EducationalRegulation</h3>
				</div>
				
				<div class="DataPrivacyLaw">
					<img src="../picture/law_bg.jpg" />
					<h3>DataPrivacyLaw</h3>

				</div>

			</div>
		</main>

		<footer>
			<!-- footer -->
			<div class="footer">
				<div class="left">
					<div class="desc">
						<h2>BreezeQuiz</h2>
						<p>
							BreezeQuiz is an interactive quiz platform enhancing
							learning with gamification, real-time analytics, and
							a resource library for students and educators to
							improve engagement and performance.
						</p>
					</div>
				</div>
				<div class="right">
					<div class="footer-logo">
						<a href="../html/index.html">
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
		</footer>
	</body>
</html>
