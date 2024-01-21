<?php
include "connection.php";
include 'session-check.php';

if (isset($_POST['deleteQuiz'])) {
    $quizIdToDelete = $_POST['quizId'];

    // Delete the quiz
    $deleteProgressQuery = "DELETE FROM tblprogress WHERE quizid = '$quizIdToDelete'";
    $deleteQuestionsQuery = "DELETE FROM tblquestion WHERE quizid = '$quizIdToDelete'";
    $deleteQuizQuery = "DELETE FROM tblquiz WHERE quizid = '$quizIdToDelete'";

    mysqli_query($connection, $deleteProgressQuery);
    mysqli_query($connection, $deleteQuestionsQuery);
    mysqli_query($connection, $deleteQuizQuery);

    // display a message
    echo "<script>alert('Quiz has been deleted.'); window.location.href = 'teacher-viewQuiz.php';</script>";
    exit();
}

// Query to fetch quizzes
$query = "SELECT quizid, quizname FROM tblquiz WHERE teacherid = '{$_SESSION['teacherid']}'";
$result = mysqli_query($connection, $query);

$quizzes = []; // to store quizzes
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $quizzes[] = $row; // add each row to the quizzes array
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quizzes</title>

    <link rel="stylesheet" href="../css/teacher-viewQuiz.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>

    <!-- quiz -->
    <div class="quizpage-wrapper">
        <div class="header">
            <h1>Quiz</h1>
            <div class="add-on-btn">
                <a href="../php/teacher-createQuiz.php" target="_blank">
                    <button type="submit">Create Quiz</button>
                </a>
            </div>
        </div>
        <div class="quizpage-container">

            <?php foreach ($quizzes as $quiz): ?>

            <div class="quiz">
                <div class="quiz-info">
                    <h3><?= htmlspecialchars($quiz['quizname']) ?></h3>
                </div>
                <div class="view-button">
                    <a href="../php/teacher-quizDesc.php ?quizid=<?= $quiz['quizid'] ?>"><button>View</button></a>
                    <form method="post">
                        <input type="hidden" name="quizId" value="<?= $quiz['quizid'] ?>">
                        <input type="submit" name="deleteQuiz" value="Delete"
                            onclick="return confirm('Are you sure you want to delete this quiz?');">
                    </form>
                </div>
            </div>

            <?php endforeach; ?>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>