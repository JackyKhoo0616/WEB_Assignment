<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

$quizId = $_GET['quizid'] ?? '';

// Fetch quiz details
$quizQuery = "SELECT quizname, creationdate FROM tblquiz WHERE quizid = '$quizId'";
$quizResult = mysqli_query($connection, $quizQuery);

if ($quizResult && $row = mysqli_fetch_assoc($quizResult)) {
    $quizName = $row['quizname'];
    $creationDate = $row['creationdate'];
} else {
    // Handle case where quiz doesn't exist
    echo "<script>alert('Quiz not found.'); window.location.href = 'teacher-viewQuiz.php';</script>";
    exit();
}

// Fetch questions for the quiz
$questionsQuery = "SELECT * FROM tblquestion WHERE quizid = '$quizId' ORDER BY questionnum";
$questionsResult = mysqli_query($connection, $questionsQuery);
$questions = mysqli_fetch_all($questionsResult, MYSQLI_ASSOC);

// Initialize the correct answers array
$correctAnswers = [];

// Extract the correct answers for each question
foreach ($questions as $question) {
    // Assuming 'answer' is formatted as 'questionnum-choice', e.g., '1-a'
    list($questionNum, $correctOption) = explode('-', $question['answer']);
    $questionNum = trim($questionNum);
    $correctOption = trim($correctOption);
    
    // Store the correct answer with the question number as key
    $correctAnswers[$question['questionnum']] = $correctOption;
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
                                value="<?php echo $question['choice' . $option]; ?>"
                                <?php echo ($correctAnswers[$question['questionnum']] == $option) ? 'checked' : ''; ?>
                                disabled />
                            <label for="q<?php echo $question['questionnum']; ?>Ans<?php echo $option; ?>">
                                <?php echo htmlspecialchars($question['choice' . $option]); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </form>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>