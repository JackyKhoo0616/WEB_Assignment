<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

if (isset($_POST['createQuiz'])) {
    // Get the quiz name and class code from the form
    $quizName = $_POST['quizName'];
    $classCode = $_POST['classCode'];
    $currentDate = date('Y-m-d H:i:s'); // Get the current date and time

    // Check if the class code exists in tblclass
    $classQuery = "SELECT classid FROM tblclass WHERE classid = '$classCode'";
    $classResult = mysqli_query($connection, $classQuery);

    if ($classResult && mysqli_num_rows($classResult) == 1) {
        $classRow = mysqli_fetch_assoc($classResult);
        $classid = $classRow['classid'];

        // Insert the quiz into tblquiz and get the quizid
        $insertQuizQuery = "INSERT INTO tblquiz (teacherid, classid, quizname, creationdate) VALUES ('{$_SESSION['teacherid']}', '$classid', '$quizName', '$currentDate')";
        if (mysqli_query($connection, $insertQuizQuery)) {
            $quizid = mysqli_insert_id($connection);

            // Loop through the posted questions and insert them into tblquestion
            for ($i = 1; isset($_POST["question$i"]); $i++) {
                $question = $_POST["question$i"];
                $choiceA = $_POST["option{$i}-A"];
                $choiceB = $_POST["option{$i}-B"];
                $choiceC = $_POST["option{$i}-C"];
                $choiceD = $_POST["option{$i}-D"];
                $correctAnswer = strtolower($_POST["correctAnswer$i"]);

                $insertQuestionQuery = "INSERT INTO tblquestion (quizid, question, choicea, choiceb, choicec, choiced, answer) VALUES ('$quizid', '$question', '$choiceA', '$choiceB', '$choiceC', '$choiceD', '$correctAnswer')";
                if (!mysqli_query($connection, $insertQuestionQuery)) {
                    echo '<script>alert("Error inserting question: ' . mysqli_error($connection) . '");</script>';
                    // Break the loop if there is an error
                    break;
                }
            }
            // If loop completes without breaking, show success message
            echo '<script>alert("Quiz created successfully!");</script>';
        } else {
            echo '<script>alert("Error creating quiz: ' . mysqli_error($connection) . '");</script>';
        }
    } else {
        echo '<script>alert("Class code does not exist.");</script>';
    }
}

if (isset($_POST['createQuiz'])) {
    // ... (existing code for creating the quiz and inserting questions)

    // Assuming $quizid is set after inserting the quiz successfully
    if (isset($quizid) && $quizid > 0) {
        // Fetch all student IDs for the class
        $studentsQuery = "SELECT studentid FROM tblenrollment WHERE classid = '$classid'";
        $studentsResult = mysqli_query($connection, $studentsQuery);

        if ($studentsResult) {
            while ($student = mysqli_fetch_assoc($studentsResult)) {
                $studentId = $student['studentid'];

                // Insert 'No Attempt' status for each student for the new quiz
                $progressInsertQuery = "INSERT INTO tblprogress (studentid, quizid, status, marks, attemptdate) VALUES ('$studentId', '$quizid', 'No Attempt', NULL, NULL)";
                if (!mysqli_query($connection, $progressInsertQuery)) {
                    // Handle error here if needed
                    echo '<script>alert("Error recording progress for student ID: ' . $studentId . ' - ' . mysqli_error($connection) . '");</script>';
                }
            }
            // If progress records are created successfully
            echo '<script>alert("Quiz and questions added successfully, and progress records initialized!");</script>';
        } else {
            // Handle error here if needed
            echo '<script>alert("Error fetching students from class: ' . mysqli_error($connection) . '");</script>';
        }
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
                    <button type="button" id="addQuestion">Add Question</button>
                    <input type="submit" name="createQuiz" value="Create Quiz" />
                </div>
            </form>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>