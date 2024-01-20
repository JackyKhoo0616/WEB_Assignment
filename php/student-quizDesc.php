<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

$studentId = $_SESSION['studentid'];
$quizId = $_GET['quizid'] ?? null;

// Initialize variables to store quiz details
$classId = '';
$className = '';
$quizStatus = '';
$creationDate = '';
$marks = '';
$totalQuestions = 0;

if ($quizId !== null) {
    // Step 2: Create the SQL commands
    // get the total number of questions for the quiz
    $questionQuery = "SELECT COUNT(*) AS totalQuestions FROM tblquestion WHERE quizid = '{$quizId}'";
    $questionResult = mysqli_query($connection, $questionQuery);

    if ($questionResult && mysqli_num_rows($questionResult) > 0) {
        $questionRow = mysqli_fetch_assoc($questionResult);
        $totalQuestions = $questionRow['totalQuestions'];
    }

    // get the quiz details along with marks
    $quizQuery = "SELECT q.quizname, c.classname, p.status, p.marks, q.creationdate
                FROM tblquiz q
                LEFT JOIN tblprogress p ON q.quizid = p.quizid
                LEFT JOIN tblclass c ON q.classid = c.classid
                WHERE p.studentid = '{$studentId}' AND q.quizid = '{$quizId}'";

    // Step 3: Execute the quiz query
    $quizResult = mysqli_query($connection, $quizQuery);

    // Step 4: Read the quiz results
    if ($quizResult && mysqli_num_rows($quizResult) > 0) {
        $quizRow = mysqli_fetch_assoc($quizResult);
        $quizName = $quizRow['quizname'];
        $className = $quizRow['classname'];
        $quizStatus = $quizRow['status'] ?? 'No attempt';
        $marks = $quizRow['marks'] ?? '-';
        $creationDate = date('d F Y', strtotime($quizRow['creationdate']));

        // display marks and total questions if quiz is finished
        if ($quizStatus === 'Finished') {
            $marks = "{$marks} / {$totalQuestions}";
        }
    } else {
        // if no quiz record is found
        echo "<script>alert('No quiz found.'); window.location.href='../php/student-viewQuiz.php';</script>";
    }

    // Step 5: Close the connection
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz</title>

    <link rel="stylesheet" href="../css/student-quizDesc.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />

    <script src="../javascript/backBtnLogic.js"></script>
    <script>
    // Get the quiz status from PHP
    var quizStatus = "<?php echo $quizStatus; ?>";

    // If the quiz is finished, disable the "Start Quiz" button
    if (quizStatus === "Finish") {
        document.getElementById("startQuizButton").disabled = true;
    }
    </script>

</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <div class="main">
        <h1><?= htmlspecialchars($quizName) ?></h1>
        <div class="quiz-info">
            <table>
                <tr>
                    <th>Class Name</th>
                    <td><?= htmlspecialchars($className) ?></td>
                </tr>
                <tr>
                    <th>Quiz Status</th>
                    <td><?= htmlspecialchars($quizStatus) ?></td>
                </tr>
                <tr>
                    <th>Creation Date</th>
                    <td><?= htmlspecialchars($creationDate) ?></td>
                </tr>
                <tr>
                    <th>Marks</th>
                    <td><?= htmlspecialchars($marks) ?></td>
                </tr>
            </table>
        </div>

        <div class="quiz-button">

            <!-- Back Button -->
            <div class="back-button">
                <a href="../php/student-viewQuiz.php">
                    <button type="submit">Back</button>
                </a>
            </div>

            <!-- Start Quiz Button -->
            <?php if ($quizStatus !== 'Finished'): ?>
            <div class="start-button">
                <a href="../php/student-answerQuiz.php?quizid= <?php echo urlencode($quizId); ?>">
                    <button type="submit">Start Quiz</button>
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>