<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

$studentId = $_SESSION['studentid'];
$quizId = $_GET['quizid'] ?? null;

$quizName = '';
$creationDate = '';
$questions = [];

if ($quizId !== null) {
    // Step 2: Create the SQL commands
    $quizQuery = "SELECT quizname, creationdate FROM tblquiz WHERE quizid = '{$quizId}'";

    // Step 3: Execute the query
    $quizResult = mysqli_query($connection, $quizQuery);

    // Step 4: Read the results for quiz details
    if ($quizResult && mysqli_num_rows($quizResult) > 0) {
        $quizRow = mysqli_fetch_assoc($quizResult);
        $quizName = $quizRow['quizname'];
        $creationDate = date('d F Y', strtotime($quizRow['creationdate']));

        // Get the questions for the quiz
        $questionQuery = "SELECT * FROM tblquestion WHERE quizid = '{$quizId}' ORDER BY questionnum ASC";
        $questionResult = mysqli_query($connection, $questionQuery);
        while ($questionRow = mysqli_fetch_assoc($questionResult)) {
            $questions[] = $questionRow;
        }
    } else {
        echo "<script>alert('Error in finding quiz.'); window.location.href='../php/student-viewQuiz.php';</script>";
        mysqli_close($connection);
        exit;
    }
    
} else {
    echo "<script>alert('Quiz ID not found.'); window.location.href='../php/student-viewQuiz.php';</script>";
    exit;
}


if (isset($_POST['btnSubmit']) && $quizId !== null) {
    
    // Fetch all the correct answers
    $query = "SELECT questionnum, answer, choicea, choiceb, choicec, choiced FROM tblquestion WHERE quizid = '{$quizId}'";
    $result = mysqli_query($connection, $query);

    $correctAnswers = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Split the answer into the question number and the correct choice
        list($questionPart, $choicePart) = explode('-', $row['answer']);
        $questionNum = str_replace('option', '', $questionPart); // Get the question number
        // Get the correct answer value
        $correctAnswerValue = $row['choice' . $choicePart];
        $correctAnswers[$questionNum] = $correctAnswerValue;
    }

    // Calculate the marks
    $totalQuestions = count($correctAnswers);
    $marks = 0;

    foreach ($correctAnswers as $questionNum => $correctAnswerValue) {
        // Check if the submitted answer matches the correct answer value
        if (isset($_POST['q' . $questionNum]) && $_POST['q' . $questionNum] === $correctAnswerValue) {
            $marks++;
        }
    }
    
    // Update tblprogress
    $updateQuery = "UPDATE tblprogress SET status = 'Finished', marks = '{$marks}', attemptdate = NOW() WHERE studentid = '{$studentId}' AND quizid = '{$quizId}'";

    // Execute the update query
    $updateResult = mysqli_query($connection, $updateQuery);
    
    if ($updateResult) {
        $redirectUrl = "../php/student-quizCompleted.php?quizid=" . urlencode($quizId);
        echo "<script>alert('Submitted successfully.'); window.location.href='" . $redirectUrl . "';</script>";
    } else {
        echo "<script>alert('Error submitting quiz.'); window.location.href='../php/student-viewQuiz.php';</script>";
    }

    // Close the connection
    mysqli_close($connection);
}
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
            <form action="" method="post">
                <?php foreach ($questions as $index => $question): ?>
                <div class="question-body">
                    <div class="quiz-question">
                        <h2>Question <?php echo ($index + 1); ?></h2>
                        <p><?php echo htmlspecialchars($question['question']); ?></p>
                    </div>
                    <div class="quiz-answers">
                        <?php foreach (['a', 'b', 'c', 'd'] as $option): ?>
                        <div class="answer">
                            <input type="radio" name="q<?php echo $question['questionnum']; ?>"
                                id="q<?php echo $question['questionnum']; ?>Ans<?php echo $option; ?>"
                                value="<?php echo $question['choice' . $option]; ?>" />
                            <label
                                for="q<?php echo ($index + 1); ?>Ans<?php echo $option; ?>"><?php echo htmlspecialchars($question['choice' . $option]); ?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
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