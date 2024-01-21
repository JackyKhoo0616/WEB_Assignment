<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['admin']);

// Initialize counts
$totalQuizzes = 0;
$totalLearningMaterials = 0;
$totalStudents = 0;
$totalTeachers = 0;

// Count total quizzes
$queryQuizzes = "SELECT COUNT(*) as total FROM tblquiz";
$resultQuizzes = mysqli_query($connection, $queryQuizzes);
if ($resultQuizzes) {
    $rowQuizzes = mysqli_fetch_assoc($resultQuizzes);
    $totalQuizzes = $rowQuizzes['total'];
}

// Count total learning materials
$queryLearningMaterials = "SELECT COUNT(*) as total FROM tbllm";
$resultLearningMaterials = mysqli_query($connection, $queryLearningMaterials);
if ($resultLearningMaterials) {
    $rowLearningMaterials = mysqli_fetch_assoc($resultLearningMaterials);
    $totalLearningMaterials = $rowLearningMaterials['total'];
}

// Count total students
$queryStudents = "SELECT COUNT(*) as total FROM tblstudents";
$resultStudents = mysqli_query($connection, $queryStudents);
if ($resultStudents) {
    $rowStudents = mysqli_fetch_assoc($resultStudents);
    $totalStudents = $rowStudents['total'];
}

// Count total teachers
$queryTeachers = "SELECT COUNT(*) as total FROM tblteachers";
$resultTeachers = mysqli_query($connection, $queryTeachers);
if ($resultTeachers) {
    $rowTeachers = mysqli_fetch_assoc($resultTeachers);
    $totalTeachers = $rowTeachers['total'];
}

// close the database
mysqli_close($connection);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/admin-adminDashboard.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-admin-nav.php"; ?>

    <!-- headline & welcome msg -->
    <div class="data-analysis">
        <div class="datawrapper">
            <h1>Data Analysis</h1>
            <div class="data-up">
                <div class="data">
                    <h2>Total Quizzes</h2>
                    <p><?php echo $totalQuizzes; ?></p>
                </div>
                <div class="data">
                    <h2>Total Learning Material</h2>
                    <p><?php echo $totalLearningMaterials; ?></p>
                </div>
            </div>
            <div class="data-down">
                <div class="data">
                    <h2>Total Students</h2>
                    <p><?php echo $totalStudents; ?></p>
                </div>
                <div class="data">
                    <h2>Total Teachers</h2>
                    <p><?php echo $totalTeachers; ?></p>
                </div>
            </div>
        </div>
    </div>


    <!-- function -->
    <div class="funtion">
        <div class="function-container">
            <h1>Admin Function</h1>
            <div class="button">
                <a href="../php/admin-adminSearchUser.php" target="_blank">
                    <button>Search User Details</button>
                </a>
            </div>
            <div class="button">
                <a href="../php/admin-adminSearchQuiz.php" target="_blank">
                    <button>Access All Quiz</button>
                </a>
            </div>
            <div class="button">
                <a href="../php/admin-adminSearchLearning.php" target="_blank">
                    <button>Access All Learning Material</button>
                </a>
            </div>
        </div>
    </div>

    <!-- Other -->
    <div class="other">
        <div class="other-container">
            <h1>Other Page</h1>
            <div class="the-page">
                <a href="../php/user-eduRegulation.php" target="_blank">
                    <div class="link">
                        <h2>Educational Regulation</h2>
                        <img src="../picture/regulations.jpg" alt="" />
                    </div>
                </a>
                <a href="../php/user-dataPrivacy.php" target="_blank">
                    <div class="link">
                        <h2>Data Privacy Law</h2>
                        <img src="../picture/dataPrivacy.jpg" alt="" />
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>