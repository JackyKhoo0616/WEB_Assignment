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
    
} else {
    echo "<script>alert('No quiz ID provided.'); window.location.href='../php/student-viewQuiz.php';</script>";
    exit;
}





// Gamification part

// Fetch all the quiz attempts for the student
$quizAttemptQuery = "SELECT * FROM tblprogress WHERE studentid = '{$studentId}'";
$quizAttemptResult = mysqli_query($connection, $quizAttemptQuery);
$quizAttempts = mysqli_fetch_all($quizAttemptResult, MYSQLI_ASSOC);

// Fetch the total number of quizzes attempted
$totalQuizzesAttempted = count($quizAttempts);

// Function to update badge collection number
function updateBadgeCollection($connection, $studentId, $badgeId) {
    // Check current collection number
    $checkBadgeQuery = "SELECT collectionnum FROM tblaward WHERE studentid = '{$studentId}' AND badgeid = '{$badgeId}'";
    $checkBadgeResult = mysqli_query($connection, $checkBadgeQuery);

    if ($row = mysqli_fetch_assoc($checkBadgeResult)) {
        // Badge exists, increment collection number
        $newCollectionNum = $row['collectionnum'] + 1;
        $updateBadgeQuery = "UPDATE tblaward SET collectionnum = '{$newCollectionNum}' WHERE studentid = '{$studentId}' AND badgeid = '{$badgeId}'";
    } else {
        // Badge doesn't exist, insert new record
        $newCollectionNum = 1;
        $updateBadgeQuery = "INSERT INTO tblaward (studentid, badgeid, collectionnum) VALUES ('{$studentId}', '{$badgeId}', '{$newCollectionNum}')";
    }

    mysqli_query($connection, $updateBadgeQuery);
}

// Fetch total number of questions for the quiz
$totalQuestionsQuery = "SELECT COUNT(*) as totalQuestions FROM tblquestion WHERE quizid = '{$quizId}'";
$totalQuestionsResult = mysqli_query($connection, $totalQuestionsQuery);
$totalQuestionsRow = mysqli_fetch_assoc($totalQuestionsResult);
$totalQuestions = $totalQuestionsRow['totalQuestions'];

// Determine the percentage of correct answers
$percentageCorrect = ($marks / $totalQuestions) * 100;

// Determine which badge(s) to award
if ($percentageCorrect == 100) {
    updateBadgeCollection($connection, $studentId, 1); // Quiz master
} elseif ($percentageCorrect >= 75 && $percentageCorrect < 100) {
    updateBadgeCollection($connection, $studentId, 2); // Quick learner
} elseif ($percentageCorrect > 0 && $percentageCorrect <= 25) {
    updateBadgeCollection($connection, $studentId, 3); // The lost lamb
} elseif ($percentageCorrect == 0) {
    updateBadgeCollection($connection, $studentId, 4); // Try again
}

// Close the connection
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