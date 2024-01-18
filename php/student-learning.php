<?php
session_start();
include "connection.php";  // Include the connection file
include "session-check.php";

// Check if the teacher is logged in
if ($_SESSION['role'] == 'teacher') {
    $teacherid = $_SESSION['teacherid'];

    // Fetch quiz details from tblcontent based on tbllm
    $lm_query = "SELECT c.* FROM tblcontent c
                  JOIN tbllm lm ON c.lmid = lm.lmid
                 WHERE lm.teacherid = '$teacherid'";
    $lm_result = mysqli_query($connection, $lm_query);

    // Check if the query was successful
    if ($lm_result) {
        // Fetch quiz details
        $lm_data = mysqli_fetch_assoc($lm_result);

        // Display quiz details
        $description = $lm_data['description'];
        $video = $lm_data['video'];

        // Output HTML with dynamic quiz details
        echo <<<HTML

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Learning Material</title>

        <link rel="stylesheet" href="../css/student-learning.css" />
        <link rel="stylesheet" href="../css/footer.css" />
    </head>
    <body>
        <div class="learning-content">
            <h1>Learning Material 1</h1>
            <p>
                $description
            </p>

            <div class="additional">
                <iframe
                    width="1200"
                    height="600"
                    src="$video"
                    title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                ></iframe>
            </div>
        </div>

        <!-- footer -->
        <div class="footer">
            <!-- Your footer content remains unchanged -->
        </div>

        <!-- copyright part -->
        <div class="copyright">
            <p>© 2024 BreezeQuiz. All rights reserved.</p>
        </div>
    </body>
</html>
HTML;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Learning Material</title>

		<link rel="stylesheet" href="../css/student-learning.css" />
		<link rel="stylesheet" href="../css/footer.css" />
	</head>
	<body>
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
