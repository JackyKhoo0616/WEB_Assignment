<?php
include 'connection.php';
include "session-check.php";

checkPageAccess(['admin']);

$row = array();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
	// Retrieve form data
	$userid = $_POST["userid"];
	$userfullname = $_POST["userfullname"];
	$userroles = $_POST["userroles"];
	$classcode = $_POST["classcode"];

	// Check if user role is admin
	if ($_SESSION['role'] != "admin") {
		echo "You do not have permission to perform this action.";
		exit();
	}

	 // Check if both fields are empty
	 if (empty($userid) && empty($userfullname)) {
        echo "Please fill out either the User ID or User Full Name field.";
        exit();
    }

	$params = array();
	$types = "";
    $query = "SELECT * FROM tblstudents WHERE ";

    // Check if userid is provided
    if (!empty($userid)) {
        $query .= "studentid = ?";
        array_push($params, $userid);
        $types .= "s";
    }

    // Check if userfullname is provided
    if (!empty($userfullname)) {
        // If userid is also provided, add an OR clause
        if (!empty($userid)) {
            $query .= " OR ";
        }
        $query .= "CONCAT(fname, ' ', lname) = ?";
        array_push($params, $userfullname);
        $types .= "s";
    }

    $stmt = $connection->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, fetch details
        $row = $result->fetch_assoc();
    } else {
        echo "No user found with the given details.";
    }

    // Close the database connection
    $stmt->close();
    $connection->close();
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit"])) {
	// Retrieve form data
	$userid = $_POST["studentid"];
	$dob = $_POST["dob"];
	$gender = $_POST["gender"];
	$email = $_POST["email"];     
	$password = $_POST["password"];     

	// Prepare the SQL query
	$query = "UPDATE tblstudents SET dob = ?, gender = ?, email = ?, `password` = ? WHERE studentid = ?";
	$stmt = $connection->prepare($query);
	$stmt->bind_param("sssss", $dob, $gender, $email, $password, $userid);
	$stmt->execute();

	// Close the statement and the database connection
	$stmt->close();
	$connection->close();

	echo "<script>alert('User information updated successfully.');</script>";	
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
						<li>
						<a href="">Home</a>
						<div class="sub-menu">
								<ul>
									<li><a href="user-index.php">Main Page</a></li>
									<li><a href="admin-adminDashboard.php">Dashboard</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="">Service</a>
							<div class="sub-menu">
								<ul>
									<li><a href="student-viewQuiz.php">Quiz</a></li>
									<li><a href="student-viewLearning.php">Learning Material</a></li>
								</ul>
							</div>
						</li>
						<li><a href="user-aboutUs.php">About Us</a></li>
						<li>
							<a href="">Other Pages</a>
							<div class="sub-menu">
								<ul>
									<li><a href="user-register.php">Sign Up</a></li>
									<li>
										<a href="user-eduRegulation.php">Educational Regulation</a>
									</li>
									<li><a href="user-dataPrivacy.php">Data Privacy Law</a></li>
								</ul>
							</div>
						</li>
						<button class="login"><a href="user-login.php">Login</a></button>
					</ul>
				</div>

				<div class="content">

					<div class="boxWrapper">
	
						<form action="admin-searchUserDetail.php" method="post">
							<h1>Enter User Details</h1>
	
							<div class="boxlvl1">
								<div class="input-box">
									<input
										type="text"
										id="userid"
										name="userid"
										placeholder="User ID"
									/>
								</div>
							
	
								<div class="input-box">
									<input
										type="text"
										name="userfullname"
										placeholder="User Fullname"
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
									/>
								</div>
							</div>
	
							<input 
							name="search"
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

	
		<form action="" method="POST">
			<div class="infoWrapper">
				<div class="studentInfo" id="sutdentInfo">
					<div class="info-box">
						<div class="label">ID:</div>
						<div class="value"><?php echo isset($row['studentid']) ? $row['studentid'] : ''; ?></div>
						<input type="hidden" name="studentid" value="<?php echo isset($row['studentid']) ? $row['studentid'] : ''; ?>">
					</div>
					<div class="info-box">
						<div class="label">Full Name:</div>
						<input 
						class="value" style="text-align: center;" value="<?php echo isset($row['fname']) ? $row['fname'] . " " . $row['lname'] : ''; ?>"></input>	
					</div>
					<div class="info-box">
						<div class="label">Date of Birth:</div>
						<input 
						name="dob"
						class="value" style="text-align: center;" value="<?php echo isset($row['dob']) ? $row['dob'] : ''; ?>"></input>	
					</div>
					<div class="info-box">
						<div class="label">Gender:</div>			
						<input 
						name="gender"
						class="value" style="text-align: center;" value="<?php echo isset($row['gender']) ? $row['gender'] : ''; ?>"></input>
					</div>
					<div class="info-box">
						<div class="label">Email:</div>
						<input 
						name="email"
						class="value" style="text-align: center;" value="<?php echo isset($row['email']) ? $row['email'] : ''; ?>"></input>
					</div>
					<div class="info-box">
						<div class="label">Password:</div>
						<input 
						name="password"
						class="value" style="text-align: center;" value="<?php echo isset($row['password']) ? $row['password'] : ''; ?>"></input>
					</div>

					<div class="button-wrapper">
						<button class="info-button" name="edit">Edit</button>
					</div>
				</div>
		</form>

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
