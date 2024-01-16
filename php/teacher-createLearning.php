<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);
?>

<?php
if (isset($_POST['btnCreateLM'])) {
    // Assuming $connection is your database connection
    $lmname = $_POST['lmname'];
    $description = $_POST['description'];
    $video = $_POST['video'];
    $teacherid = $_SESSION['teacherid']; // Assuming you have a teacher session after login
    $classid = $_POST['classid'];
    $creationdate = date("Y-m-d H:i:s"); // Current date and time

    // Insert learning material details into tbllm
    $insertLMQuery = "INSERT INTO tbllm (teacherid, classid, creationdate) VALUES ('$teacherid', '$classid', '$creationdate')";
    mysqli_query($connection, $insertLMQuery);

    // Retrieve the autogenerated lmid
    $lmid = mysqli_insert_id($connection);

    // Insert learning material content into tblcontent
    $insertContentQuery = "INSERT INTO tblcontent (lmid, lmname, description, video) VALUES ('$lmid', '$lmname', '$description', '$video')";
    mysqli_query($connection, $insertContentQuery);

    echo "Learning material created successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Create Learning Material</title>

		<link rel="stylesheet" href="../css/teacher-createLearning.css" />
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/footer.css" />

		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Lemon&display=swap"
			rel="stylesheet"
		/>

		<script src="../javascript/wordLimit.js"></script>
	</head>
	<body>
		<!-- content -->
		<div class="main-wrapper">
			<h1>Create Learning Material</h1>
			<div class="input-area">
				<form action="#" method="post">
					<label for="quizName">Learning Material Name</label>
					<input
						type="text"
						name="quizName"
						id="quizName"
						placeholder="Enter Learning Material Name"
						required
					/>
					<label for="classCode">Class Code</label>
					<input
						type="text"
						name="classCode"
						id="classCode"
						placeholder="Enter Class Code"
						required
					/>
					<div class="content">
						<div class="text">
							<label for="textarea">Content</label>
							<textarea
								name="textarea"
								id="textarea"
								cols="30"
								rows="10"
								placeholder="Enter Content Here"
								required
							></textarea>
						</div>
						<div class="video">
							<label for="video"> Youtube Video Link</label>
							<input
								type="text"
								name="video"
								id="video"
								placeholder="Enter Youtube Video Link"
							/>
						</div>
					</div>
					<div class="btn">
						<button type="submit">Create Learning Module</button>
					</div>
				</form>
			</div>
		</div>
		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>
