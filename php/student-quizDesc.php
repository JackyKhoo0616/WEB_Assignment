<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

$studentId = $_SESSION['studentid']; // Assuming you store student ID in the session
$quizId = $_GET['quizid'] ?? null; // The quiz ID should be passed as a parameter in the URL

// Initialize variables to store quiz details
$classId = '';
$className = '';
$quizStatus = 'No attempt';
$creationDate = '';
$marks = '-';

if ($quizId !== null) {
    // Prepare the SQL query to retrieve quiz details and progress
    $query = "SELECT q.classid, c.classname, q.quizname, q.creationdate, p.status, p.marks
                FROM tblquiz q
                LEFT JOIN tblprogress p ON q.quizid = p.quizid AND p.studentid = ?
                LEFT JOIN tblclass c ON q.classid = c.classid
                WHERE q.quizid = ?";

    if ($stmt = mysqli_prepare($connection, $query)) { // Bind parameters
    mysqli_stmt_bind_param($stmt, "ii", $studentId, $quizId); // Execute the query
    mysqli_stmt_execute($stmt); // Bind the result variables
    mysqli_stmt_bind_result($stmt, $classId, $className, $quizName, $creationDate, $quizStatus, $marks);  // Fetch the results

        if (mysqli_stmt_fetch($stmt)) {
            // If the quiz has been attempted, format the date and marks
            $creationDate = date('d F Y', strtotime($creationDate));
            $marks = $quizStatus === 'Finish' ? $marks : '-';
            
        }else {
            // Handle the case where no quiz record is found
            echo '<script>alert("No quiz found."); window.location.href="../php/student-viewQuiz.php";</script>';
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle errors with the query
        echo "SQL Error: " . htmlspecialchars(mysqli_error($connection));
    }
}

// Close the database connection
mysqli_close($connection);
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
    < script >
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
            <div class="back-button">
                <a href="../php/student-viewQuiz.php">
                    <button type="submit">Back</button>
                </a>
            </div>
            <div class="start-button">
                <?php if ($quizStatus !== 'Finish'): ?>

                <a href="../php/student-answerQuiz.php">
                    <button type="submit">Start Quiz</button>
                </a>

                <?php else: ?>

                <!-- If the quiz is finished, disable the button -->

                <button type="submit" disabled>Quiz Completed</button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>