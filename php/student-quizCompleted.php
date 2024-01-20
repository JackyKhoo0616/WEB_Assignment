<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

$studentId = $_SESSION['studentid'];
$quizId = $_GET['quizid'] ?? null;

$quizName = '';
$marks = '';
$totalQuestions = 0;

if ($quizId !== null) {
    // Fetch quiz name and marks
    $progressQuery = "SELECT q.quizname, p.marks
                    FROM tblprogress p
                    JOIN tblquiz q ON p.quizid = q.quizid
                    WHERE p.studentid = '{$studentId}' AND p.quizid = '{$quizId}'";
                    
    $progressResult = mysqli_query($connection, $progressQuery);

    if ($progressRow = mysqli_fetch_assoc($progressResult)) {
        $quizName = $progressRow['quizname'];
        $marks = $progressRow['marks'];
    }

    // Fetch total number of questions
    $questionQuery = "SELECT COUNT(*) AS totalQuestions FROM tblquestion WHERE quizid = '{$quizId}'";
    $questionResult = mysqli_query($connection, $questionQuery);

    if ($questionRow = mysqli_fetch_assoc($questionResult)) {
        $totalQuestions = $questionRow['totalQuestions'];
    }

    mysqli_close($connection);
} else {
    echo "<script>alert('No quiz ID provided.'); window.location.href='../php/student-viewQuiz.php';</script>";
    exit;
}
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
            <h1>Congratulations</h1>
            <p>You have completed _<?php echo htmlspecialchars($quizName); ?>_</p>
        </div>
        <div class="details">
            <p>You Answered</p>
            <h3><?php echo htmlspecialchars($marks) . ' / ' . htmlspecialchars($totalQuestions); ?></h3>
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