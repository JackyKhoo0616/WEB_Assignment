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
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <img src="../picture/logo.png" class="header-img" />
    <div class="wrapper">
        <form action="#" method="post">
            <h1>Login</h1>
            <?php
				include "session-check.php";

				if (isset($_POST['btnlogin'])) {
					$email = $_POST['txtEmail'];
					$password = $_POST['txtPassword'];

					$queryStudents = "SELECT * FROM tblstudents WHERE email='$email' AND password='$password'";
					$resultStudents = mysqli_query($connection, $queryStudents);

					$queryTeachers = "SELECT * FROM tblteachers WHERE email='$email' AND password='$password'";
					$resultTeachers = mysqli_query($connection, $queryTeachers);

					$queryAdmin = "SELECT * FROM tbladmin WHERE email='$email' AND password='$password'";
					$resultAdmin = mysqli_query($connection, $queryAdmin);

					if (mysqli_num_rows($resultStudents) == 1) {
						$studentData = mysqli_fetch_assoc($resultStudents);
						$_SESSION['studentid'] = $studentData['studentid'];
						$_SESSION['fname'] = $studentData['fname'];
						$_SESSION['lname'] = $studentData['lname'];
						$_SESSION['email'] = $studentData['email'];
						$_SESSION['dob'] = $studentData['dob'];
						$_SESSION['country'] = $studentData['country'];
						$_SESSION['gender'] = $studentData['gender'];
						$_SESSION['password'] = $studentData['password'];
						$_SESSION['role'] = 'student';
						header("Location: student-studentDashboard.php");
						exit();


					} elseif (mysqli_num_rows($resultTeachers) == 1) {
						$teacherData = mysqli_fetch_assoc($resultTeachers);
						$_SESSION['teacherid'] = $teacherData['teacherid'];
						$_SESSION['fname'] = $teacherData['fname'];
						$_SESSION['lname'] = $teacherData['lname'];
						$_SESSION['email'] = $teacherData['email'];
						$_SESSION['dob'] = $studentData['dob'];
						$_SESSION['country'] = $studentData['country'];
						$_SESSION['gender'] = $studentData['gender'];
						$_SESSION['password'] = $studentData['password'];
						$_SESSION['role'] = 'teacher';
						header("Location: teacher-teacherDashboard.php");
						exit();

						
					} elseif (mysqli_num_rows($resultAdmin) == 1) {
						$_SESSION['role'] = 'admin';
						header("Location: admin-adminDashboard.php");
						exit();

						
					} else {
						echo '<script>alert("Record Not Found")</script>';
					}

					mysqli_close($connection);
				}
				?>

            <div class="input-box">
                <input type="email" name="txtEmail" placeholder="Email" required />
            </div>
            <div class="input-box">
                <input type="password" name="txtPassword" placeholder="Password" required />
            </div>
            <div class="forgot">
                <a href="#">Forgot Password?</a>
            </div>
            <input type="submit" name="btnlogin" class="submit" value="Login" />
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