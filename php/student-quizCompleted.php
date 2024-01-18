<?php
session_start();
include "connection.php";

// get the quiz ID and student ID stored in the session
$quizId = $_SESSION['quizId']; // Replace with the actual quiz ID
$studentId = $_SESSION['studentid']; // Replace with the actual student ID

$query = "SELECT q.quizname, p.marks
			FROM tblquiz q
			INNER JOIN tblprogress p ON q.quizid = p.quizid
			WHERE p.studentid = ? AND q.quizid = ?";
if ($stmt = mysqli_prepare($connection, $query)) {
    mysqli_stmt_bind_param($stmt, "ii", $studentId, $quizId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $quizName, $marks);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
}
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz</title>
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../css/student-quizCompleted.css" />
</head>

<body>
    <div class="container">
        <div class="congrate">
            <h1>Congratulation</h1>
            <p>You have completed <?php echo htmlspecialchars($quizName); ?></p>
        </div>
        <div class="details">
            <p>You Answered</p>
            <h3><?php echo htmlspecialchars($marks); ?></h3>
            <p>Question Correct</p>
        </div>
        <div class="btn">
            <a href="../php/student-studentDashboard.php">
                <button>Back to Dashboard</button>
            </a>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>

</body>

</html>