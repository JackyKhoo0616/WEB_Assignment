<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Progress Tracker</title>

		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />
		<link rel="stylesheet" href="../css/teacher-progressTracker.css" />

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
				<h1>Performance Monitoring</h1>
			</div>
			<div class="filter-section">
				<h2>Filter by:</h2>
				<div class="filter">
					<h3>Student ID:</h3>
					<input
						type="text"
						name="studentID"
						id="studentID"
						placeholder="Student ID"
					/>
					<h3>Class Code:</h3>
					<select name="code" id="code">
						<option value="all">All</option>
						<option value="math">1</option>
					</select>
					<h3>Quiz Name:</h3>
					<select name="quiz" id="quiz">
						<option value="all">All</option>
						<option value="a">A</option>
						<option value="b">B</option>
						<option value="c">C</option>
						<option value="d">D</option>
						<option value="e">E</option>
						<option value="f">F</option>
						<option value="g">G</option>
						<option value="h">H</option>
						<option value="i">I</option>
						<option value="j">J</option>
						<option value="k">K</option>
						<option value="l">L</option>
						<option value="m">M</option>
						<option value="n">N</option>
						<option value="o">O</option>
						<option value="p">P</option>
						<option value="q">Q</option>
						<option value="r">R</option>
						<option value="s">S</option>
						<option value="t">T</option>
						<option value="u">U</option>
						<option value="v">V</option>
						<option value="w">W</option>
						<option value="x">X</option>
						<option value="y">Y</option>
						<option value="z">Z</option>
					</select>
				</div>
			</div>
			<div class="tracker">
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
				</table>
			</div>
		</div>

		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
