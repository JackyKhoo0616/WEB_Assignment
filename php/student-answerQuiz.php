<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

// Assuming you have the quiz ID stored in the session or passed via GET/POST request.
$quizId = $_SESSION['quizId'] ?? null; // Replace with the actual method of obtaining quizId

// Prepare the SQL query
$quizQuery = "SELECT quizname, creationdate FROM tblquiz WHERE quizid = ?";

// Initialize variables to store quiz details
$quizName = '';
$creationDate = '';

// Retrieve questions for the quiz
$query = "SELECT * FROM tblquestion WHERE quizid = ?";
$questions = [];
if ($stmt = mysqli_prepare($connection, $query)) {
    mysqli_stmt_bind_param($stmt, "i", $quizId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
}

// Check if the form was submitted
if (isset($_POST['btnSubmit'])) {
    $totalMarks = 0;
    foreach ($questions as $question) {
        $questionNum = 'q' . $question['questionnum'];
        $selectedAnswer = $_POST[$questionNum] ?? '';
        if ($selectedAnswer == $question['answer']) {
            $totalMarks++; // Assuming each question is worth 1 mark
        }
    }

    // Calculate the score
    $totalScore = ($totalMarks / count($questions)) * 10;

    // Update tblprogress
    $updateQuery = "UPDATE tblprogress SET marks = ?, status = 'Finished' WHERE studentid = ? AND quizid = ?";
    if ($updateStmt = mysqli_prepare($connection, $updateQuery)) {
        mysqli_stmt_bind_param($updateStmt, "iii", $totalScore, $_SESSION['studentid'], $quizId);
        mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);
    }

    // Redirect or display a message
    echo "Quiz completed. Your score is: $totalScore/10";
    // Redirect to a results page or display the score
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

    <link rel="stylesheet" href="../css/student-answerQuiz.css" />
</head>

<body>
    <h1><?php echo htmlspecialchars($quizName); ?></h1>
    <div class="quiz-wrapper">
        <div class="quiz-header">
            <table>
                <tr>
                    <th>Creation Date :</th>
                    <td><?php echo htmlspecialchars($creationDate); ?></td>
                </tr>
            </table>
        </div>
        <div class="quiz-body">
            <form action="#" method="post">

                <?php foreach ($questions as $index => $question): ?>

                <div class="quiz-question">
                    <h2>Question <?php echo ($index + 1); ?></h2>
                    <p><?php echo htmlspecialchars($question['question']); ?></p>
                </div>

                <div class="quiz-answers">
                    <!-- Assuming choices are labeled 'choicea', 'choiceb', etc. in the database -->
                    <?php for ($i = 'a'; $i <= 'd'; $i++): ?>

                    <div class="answer">
                        <input type="radio" name="q<?php echo ($index + 1); ?>"
                            id="q<?php echo ($index + 1); ?>Ans<?php echo strtoupper($i); ?>"
                            value="<?php echo $question['choice' . $i]; ?>" />
                        <label
                            for="q<?php echo ($index + 1); ?>Ans<?php echo strtoupper($i); ?>"><?php echo htmlspecialchars($question['choice' . $i]); ?></label>
                    </div>

                    <?php endfor; ?>

                </div>
                <?php endforeach; ?>

                <div class="complete-button">
                    <input type="submit" value="Submit" name="btnSubmit" />
                </div>

            </form>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>