<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

if(isset($_POST['btnUpdate'])){
    $fname = $_POST['txtFname'];
    $lname = $_POST['txtLname'];
    $dob = $_POST['txtDOB'];
    $country = $_POST['txtCountry'];
    $gender = $_POST['txtGender'];
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword'];

    $query = "UPDATE `tblstudents` SET `fname`='$fname', `lname`='$lname', `email`='$email', `dob`='$dob', `country`='$country', `gender`='$gender', `password`='$password' WHERE `studentid` = '".$_SESSION['studentid']."'";

    if (mysqli_query($connection, $query)) {
        $_SESSION['fname'] = $fname;
        $_SESSION['lname'] = $lname;
        $_SESSION['dob'] = $dob;
        $_SESSION['country'] = $country;
        $_SESSION['gender'] = $gender;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        echo '<script>alert("User Information Updated Successfully"); 
		window.location.href=window.location.href;</script>';
    } else {
        echo '<script>alert("User Information Not Updated")</script>';
    }
}
mysqli_close($connection); 
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>

    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/student-viewProfile.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <!-- profile -->
    <div class="profile-wrapper">
        <div class="profile-card">
            <div class="profile-card-header">
                <h2>My Profile</h2>
            </div>
            <form action="#" method="post">
                <div class="data">
                    <label for="txtID">ID</label>
                    <input type="text" name="txtID" id="txtID" value="<?php echo $_SESSION['studentid']; ?>" />
                </div>
                <div class="data">
                    <label for="txtFname">First Name</label>
                    <input type="text" name="txtFname" id="txtFname" value="<?php echo $_SESSION['fname']; ?>" />
                </div>
                <div class="data">
                    <label for="txtLname">Last Name</label>
                    <input type="text" name="txtLname" id="txtLname" value="<?php echo $_SESSION['lname']; ?>" />
                </div>
                <div class="data">
                    <label for="txtDOB">Date of Born</label>
                    <input type="date" name="txtDOB" id="txtDOB" value="<?php echo $_SESSION['dob']; ?>" />
                </div>
                <div class="data">
                    <label for="txtCountry">Country</label>
                    <input type="text" name="txtCountry" id="txtCountry" value="<?php echo $_SESSION['country']; ?>" />
                </div>
                <div class="data">
                    <label for="txtGender">Gender</label>
                    <input type="text" name="txtGender" id="txtGender" value="<?php echo $_SESSION['gender']; ?>" />
                </div>
                <div class="data">
                    <label for="txtEmail">Email</label>
                    <input type="email" name="txtEmail" id="txtEmail" value="<?php echo $_SESSION['email']; ?>" />
                </div>
                <div class="data">
                    <label for="txtPassword">Password</label>
                    <input type="text" name="txtPassword" id="txtPassword"
                        value="<?php echo $_SESSION['password']; ?>" />
                </div>

                <div class="button-container">
                    <input type="submit" value="Update" name="btnUpdate" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>