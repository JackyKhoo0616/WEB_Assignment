<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigational Bar</title>
</head>

<link rel="stylesheet" href="../css/nav.css" />
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

<body>
    <div class="navbar">
        <a href="../php/student-studentDashboard.php">
            <img src="../picture/logo.png" class="logo" />
        </a>
        <ul>
            <li><a href="../php/teacher-viewQuiz.php">Quiz</a></li>
            <li><a href="../php/teacher-viewLearning.php">Learning Material</a></li>
            <li><a href="../php/teacher-progressTracker.php">Progress Tracker</a></li>

            <li class="no-a">Other Pages<i class="bx bxs-chevron-down"></i>
                <div class="sub-menu">
                    <ul>
                        <li><a href="../php/teacher-aboutUs.php">About Us</a></li>
                        <li><a href="../php/user-eduRegulation.php">Educational Regulation</a></li>
                        <li><a href="../php/user-dataPrivacy.php">Data Privacy Law</a></li>
                    </ul>
                </div>
            </li>

            <li class="no-a">

                <?php 
                if (isset($_SESSION['fname']) && !empty($_SESSION['fname'])) {
                    echo htmlspecialchars($_SESSION['fname']);
                } else {
                    echo "Teacher";
                }
                ?>

                <i class="bx bxs-chevron-down"></i>

                <div class="sub-menu">
                    <ul>
                        <li><a href="../php/teacher-viewProfile.php">Profile</a></li>
                        <li><a href="../php/logout.php">Log Out</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</body>

</html>

<?php
session_start();
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

// Function to insert questions into the database
function insertQuestions($connection, $quizId, $questions) {
    foreach ($questions as $question) {
        $questionText = $question['text'];
        $optionA = $question['optionA'];
        $optionB = $question['optionB'];
        $optionC = $question['optionC'];
        $optionD = $question['optionD'];
        $correctAnswer = $question['correctAnswer'];

        $insertQuestionQuery = "INSERT INTO tblquestion (quizid, question, choicea, choiceb, choicec, choiced, answer)
                                VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($connection, $insertQuestionQuery)) {
            mysqli_stmt_bind_param($stmt, "issssss", $quizId, $questionText, $optionA, $optionB, $optionC, $optionD, $correctAnswer);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['createQuiz'])) {
    $quizName = $_POST['quizName'];
    $classCode = $_POST['classCode'];
    $teacherId = $_SESSION['teacherid'];

    // Extract questions from the form data
    $questions = [];
    for ($i = 1; $i <= 10; $i++) {
        if (isset($_POST["question$i"])) {
            $questions[] = [
                'text' => $_POST["question$i"],
                'optionA' => $_POST["option$i-A"],
                'optionB' => $_POST["option$i-B"],
                'optionC' => $_POST["option$i-C"],
                'optionD' => $_POST["option$i-D"],
                'correctAnswer' => $_POST["correctAnswer$i"]
            ];
        }
    }

    // Check if class exists
    $classExistsQuery = "SELECT COUNT(*) FROM tblclass WHERE classid = ?";
    if ($classExistsStmt = mysqli_prepare($connection, $classExistsQuery)) {
        mysqli_stmt_bind_param($classExistsStmt, "i", $classCode);
        mysqli_stmt_execute($classExistsStmt);
        mysqli_stmt_bind_result($classExistsStmt, $classCount);
        mysqli_stmt_fetch($classExistsStmt);
        mysqli_stmt_close($classExistsStmt);

        if ($classCount == 0) {
            echo "<script>alert('Error: The class code you entered does not exist.');</script>";
        } else {
            // Proceed with quiz creation
            mysqli_begin_transaction($connection);

            try {
                // Insert the new quiz
                $insertQuizQuery = "INSERT INTO tblquiz (quizname, classid, teacherid, creationdate) VALUES (?, ?, ?, NOW())";
                if ($stmt = mysqli_prepare($connection, $insertQuizQuery)) {
                    mysqli_stmt_bind_param($stmt, "sii", $quizName, $classCode, $teacherId);
                    mysqli_stmt_execute($stmt);
                    $quizId = mysqli_insert_id($connection);
                    mysqli_stmt_close($stmt);
                }

                // Insert questions
                insertQuestions($connection, $quizId, $questions);

                // Update progress for each enrolled student
                $studentsQuery = "SELECT studentid FROM tblenrollment WHERE classid = ?";
                if ($stmt = mysqli_prepare($connection, $studentsQuery)) {
                    mysqli_stmt_bind_param($stmt, "i", $classCode);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $studentId);

                    while (mysqli_stmt_fetch($stmt)) {
                        $insertProgressQuery = "INSERT INTO tblprogress (studentid, quizid, status, marks, date) VALUES (?, ?, 'No Attempt', '-', NULL)";
                        if ($progressStmt = mysqli_prepare($connection, $insertProgressQuery)) {
                            mysqli_stmt_bind_param($progressStmt, "ii", $studentId, $quizId);
                            mysqli_stmt_execute($progressStmt);
                            mysqli_stmt_close($progressStmt);
                        }
                    }
                    mysqli_stmt_close($stmt);
                }

                mysqli_commit($connection);
                echo "<script>alert('Quiz created successfully');</script>";
            } catch (Exception $e) {
                mysqli_rollback($connection);
                echo "<script>alert('Error: " . htmlspecialchars($e->getMessage()) . "');</script>";
            }
        }
    }
    mysqli_close($connection);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Quiz</title>

    <link rel="stylesheet" href="../css/teacher-createQuiz.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />

    <script src="../javascript/addRemoveQuestion.js"></script>

</head>

<body>
    <!-- content -->
    <div class="main-wrapper">
        <h1>Create A Quiz</h1>
        <div class="input-area">
            <form action="#" method="post">
                <label for="quizName">Quiz Name</label>
                <input type="text" name="quizName" id="quizName" placeholder="Enter Quiz Name" required />
                <label for="classCode">Class Code</label>
                <input type="text" name="classCode" id="classCode" placeholder="Enter Class Code" required />
                <div id="questions">
                    <div class="question">
                        <label for="question1">Question 1</label>
                        <input type="text" name="question1" id="question1" placeholder="Enter The Question" required />

                        <div class="options">
                            <div class="option">
                                <label for="option1-A">Option A</label>
                                <input type="text" name="option1-A" id="option1-A" placeholder="Enter Option 1"
                                    required />
                            </div>
                            <div class="option">
                                <label for="option1-B">Option B</label>
                                <input type="text" name="option1-B" id="option1-B" placeholder="Enter Option 2"
                                    required />
                            </div>
                            <div class="option">
                                <label for="option1-C">Option C</label>
                                <input type="text" name="option1-C" id="option1-C" placeholder="Enter Option 3"
                                    required />
                            </div>
                            <div class="option">
                                <label for="option1-D">Option D</label>
                                <input type="text" name="option1-D" id="option1-D" placeholder="Enter Option 4"
                                    required />
                            </div>
                        </div>

                        <label for="correctAnswer1">Correct Answer</label>
                        <select name="correctAnswer1" id="correctAnswer1">
                            <option value="option1-A">Option A</option>
                            <option value="option1-B">Option B</option>
                            <option value="option1-C">Option C</option>
                            <option value="option1-D">Option D</option>
                        </select>
                        <div class="delete-icon" data-tooltip="Delete Question">
                            <a href="">
                                <i class="bx bx-message-square-x"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="btn">
                    <button type="button" id="addQuestion">
                        Add Question
                    </button>
                    <button type="submit" name="createQuiz">Create Quiz</button>
                </div>
            </form>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>