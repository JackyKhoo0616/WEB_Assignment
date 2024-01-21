<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

$quizId = $_GET['quizid'] ?? '';

// Delete quiz functionality
if (isset($_POST['txtDlt']) && $quizId) {
    // Delete related questions
    $deleteQuestionsQuery = "DELETE FROM tblquestion WHERE quizid = '$quizId'";
    mysqli_query($connection, $deleteQuestionsQuery);

    // Delete related progress records
    $deleteProgressQuery = "DELETE FROM tblprogress WHERE quizid = '$quizId'";
    mysqli_query($connection, $deleteProgressQuery);

    // Delete the quiz itself
    $deleteQuizQuery = "DELETE FROM tblquiz WHERE quizid = '$quizId'";
    mysqli_query($connection, $deleteQuizQuery);

    // Redirect to quiz list page or show some message
    echo "<script>alert('Quiz deleted successfully'); window.location.href = 'teacher-viewQuiz.php';</script>";
    exit();
}

// Fetch quiz details
$quizQuery = "SELECT q.quizid, q.quizname, c.classname, q.creationdate, COUNT(t.questionnum) AS total_questions 
			FROM tblquiz q
			JOIN tblclass c ON q.classid = c.classid
			LEFT JOIN tblquestion t ON q.quizid = t.quizid
			WHERE q.quizid = '$quizId'
			GROUP BY q.quizid";

$quizResult = mysqli_query($connection, $quizQuery);

if ($quizResult && mysqli_num_rows($quizResult) == 1) {
    $quizInfo = mysqli_fetch_assoc($quizResult);
} else {
    echo "<script>alert('Quiz not found.'); window.location.href = 'teacher-viewQuiz.php';</script>";
    exit();
}

mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz</title>

    <link rel="stylesheet" href="../css/teacher-quizDesc.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>

    <div class="main">
        <h1><?php echo htmlspecialchars($quizInfo['quizname']); ?></h1>
        <div class="quiz-info">
            <table>
                <tr>
                    <th>Quiz Assigned To Class</th>
                    <td><?php echo htmlspecialchars($quizInfo['classname']); ?></td>
                </tr>
                <tr>
                    <th>Creation Date</th>
                    <td><?php echo htmlspecialchars($quizInfo['creationdate']); ?></td>
                </tr>
                <tr>
                    <th>Total Questions</th>
                    <td><?php echo htmlspecialchars($quizInfo['total_questions']); ?></td>
                </tr>
            </table>
        </div>
        <div class="quiz-button">
            <a href="../php/teacher-viewQuiz.php">
                <button>Back</button>
            </a>

            <form action="" method="post">
                <input type="submit" name="txtDlt" value="Delete" />
            </form>

            <a href="../php/teacher-reviewQuiz.php?quizid= <?php echo urlencode($quizId); ?>" target="_blank">
                <button>View</button>
            </a>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>