<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

if (isset($_POST['btn-submit'])) {
    // Classroom name with proper escaping to avoid SQL injection
    $className = mysqli_real_escape_string($connection, $_POST['quizName']);
    $teacherid = $_SESSION['teacherid']; // Assuming the teacher ID is stored in the session

    // Insert new classroom into the database
    $insertClassQuery = "INSERT INTO tblclass (teacherid, classname) VALUES ('$teacherid', '$className')";

    if (mysqli_query($connection, $insertClassQuery)) {
        echo '<script>alert("Classroom created successfully!");</script>';
    } else {
        echo '<script>alert("Error creating classroom: ' . mysqli_error($connection) . '");</script>';
    }
    
    // Close the database connection
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Quiz</title>

    <link rel="stylesheet" href="../css/teacher-createClassroom.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
</head>

<body>
    <!-- content -->
    <div class="main-wrapper">
        <a href="../html/teacher-teacherDashboard.html">
            <i class="bx bx-left-arrow-alt"></i>
        </a>
        <div class="container">
            <h1>Create Classroom</h1>
            <div class="input-area">
                <form action="#" method="post">
                    <input type="text" name="quizName" id="quizName" placeholder="Enter Classroom Name" required />
                    <div class="btn">
                        <button type="submit" class="btn-submit" name="btn-submit">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>