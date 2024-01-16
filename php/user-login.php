<?php
include "connection.php";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>Login</title>
		<link rel="stylesheet" href="../css/user-login.css" />
		<link
			href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
			rel="stylesheet"
		/>
	</head>
	<body>
		<img src="../picture/logo.png" class="header-img" />
		<div class="wrapper">
			<form action="#" method="post">
				<h1>Login</h1>
				<?php
					if (isset($_POST['btnlogin'])) {
					$email = $_POST['txtEmail'];
					$password = $_POST['txtPassword'];

					// Check credentials in tblstudents
					$queryStudents = "SELECT * FROM tblstudents WHERE email='$email' AND password='$password'";
					$resultStudents = mysqli_query($connection, $queryStudents);

					// Check credentials in tblteachers
					$queryTeachers = "SELECT * FROM tblteachers WHERE email='$email' AND password='$password'";
					$resultTeachers = mysqli_query($connection, $queryTeachers);

					$queryAdmin = "SELECT * FROM tbladmin WHERE email='$email' AND password='$password'";
					$resultAdmin = mysqli_query($connection, $queryAdmin);

					if (mysqli_num_rows($resultStudents) == 1) {
						// Login as a student
						echo 'Record Found';
						header("Location: student-studentDashboard.php");
					} elseif (mysqli_num_rows($resultTeachers) == 1) {
						// Login as a teacher
						echo 'Record Found';
						header("Location: teacher-teacherDashboard.php");
					} elseif (mysqli_num_rows($resultAdmin) == 1) {
						// Login as a admin
						echo 'Record Found';
						header("Location: admin-adminDashboard.php");
					}
					else {
						// Record not found in either table
						echo 'Record Not Found';
					}

					mysqli_close($connection);
				}
				?>
				<div class="input-box">
					<input
						type="email"
						name="txtEmail"
						placeholder="Email"
						required
					/>
				</div>
				<div class="input-box">
					<input
						type="password"
						name="txtPassword"
						placeholder="Password"
						required
					/>
				</div>
				<div class="forgot">
					<a href="#">Forgot Password?</a>
				</div>
				<input type="submit" class="submit" value="Login" />
				<div class="register-link">
					<p>Don't have an account? <a href="../php/user-register.php">Sign Up</a></p>
				</div>
			</form>
		</div>
		<!-- copyright part -->
		<div class="copyright">
			<p>© 2024 BreezeQuiz. All rights reserved.</p>
		</div>
	</body>
</html>