<?php
include 'connection.php';
include "session-check.php";

checkPageAccess(['admin']);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $userid = $_POST["userid"];
    $userfullname = $_POST["userfullname"];
    $userroles = $_POST["userroles"];
    $classcode = $_POST["classcode"];

    // Search for user based on the provided criteria
    if ($userroles == "teacher") {
        // Search in tblteachers
        $query = "SELECT * FROM tblteachers WHERE teacherid = ? OR CONCAT(fname, ' ', lname) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $userid, $userfullname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, display details
            $row = $result->fetch_assoc();
            // Display teacher details here
            echo "Teacher Details: ";
            echo "ID: " . $row['teacherid'] . "<br>";
            echo "First Name: " . $row['fname'] . "<br>";
            echo "Last Name: " . $row['lname'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Date of Birth: " . $row['dob'] . "<br>";
            echo "Country: " . $row['country'] . "<br>";
            echo "Gender: " . $row['gender'] . "<br>";
            // Display other details as needed
        } else {
            echo "The User Has Not Found";
        }

    } elseif ($userroles == "student") {
        // Search in tblstudents
        $query = "SELECT * FROM tblstudents WHERE studentid = ? OR CONCAT(fname, ' ', lname) = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $userid, $userfullname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, display details
            $row = $result->fetch_assoc();
            // Display student details here
            echo "Student Details: ";
            echo "ID: " . $row['studentid'] . "<br>";
            echo "First Name: " . $row['fname'] . "<br>";
            echo "Last Name: " . $row['lname'] . "<br>";
            echo "Email: " . $row['email'] . "<br>";
            echo "Date of Birth: " . $row['dob'] . "<br>";
            echo "Country: " . $row['country'] . "<br>";
            echo "Gender: " . $row['gender'] . "<br>";
            // Display other details as needed
        } else {
            echo "The User Has Not Found";
        }

    } else {
        echo "Invalid user role";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>BreezeQuiz</title>
		<link rel="stylesheet" href="../css/nav.css" />
		<link rel="stylesheet" href="../css/admin-searchUserDetail.css" />
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
						<button class="login"><a href="login.html">Login</a></button>
					</ul>
				</div>

				<div class="content">

					<div class="boxWrapper">
	
						<form action="searchUserDetail.php" method="post">
							<h1>Enter User Details</h1>
	
							<div class="boxlvl1">
								<div class="input-box">
									<input
										type="text"
										name="userid"
										placeholder="User ID"
										required
									/>
								</div>
							
	
								<div class="input-box">
									<input
										type="text"
										name="userfullname"
										placeholder="User Fullname"
										required
									/>
								</div>
	
								<div class="input-box">
									<select name="userroles" class="input-field" required>
										<option value="" disabled selected hidden>User's Role</option>
										<option value="student">Student</option>
										<option value="teacher">Teacher</option>
									</select>
								</div>
							</div>
	
							<div class="boxlvl2">
								<div class="input-box">
									<input
										type="text"
										name="classcode"
										placeholder="Class Code"
										required
									/>
								</div>
							</div>
	
							<input 
								type="submit" 
								class="submit" 
								value="Search" 
								onclick="location.href='#sutdentInfo';"/>
						</form>
					</div>
				</div>
				
			</div>
		</header>

		<main>
			<div class="infoWrapper">

					<div class="studentInfo" id="sutdentInfo">
						<div class="info-box">
							<div class="label">ID:</div>
							<div class="value">ID 0001</div>
						</div>
						<div class="info-box">
							<div class="label">Full Name:</div>
							<div class="value">Jacky khoo</div>
						</div>
						<div class="info-box">
							<div class="label">Date of Birth:</div>
							<div class="value">2016-06-03</div>
						</div>
						<div class="info-box">
							<div class="label">Gender:</div>
							<div class="value">male</div>
						</div>
						<div class="info-box">
							<div class="label">Email:</div>
							<div class="value">jk@gmail.com</div>
						</div>
						<div class="info-box">
							<div class="label">Password:</div>
							<div class="value">Password</div>
						</div>

						<div class="button-wrapper">
						<button class="info-button">Edit</button>
					</div>
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
