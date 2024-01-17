<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['student']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/student-studentDashboard.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <!-- top part -->
    <div class="header">
        <div class="img-container">
            <img src="../picture/header_student.png" />
        </div>
    </div>
    <div class="search">
        <form action="">
            <h1>Join A Class</h1>
            <div class="search-container">
                <i class="bx bx-search"></i>
                <input type="text" placeholder="Enter Class Code" required />
            </div>
            <div class="button-container">
                <a href="#">
                    <button type="submit">Join</button>
                </a>
            </div>
        </form>
    </div>

    <div class="content">
        <!-- quiz -->
        <div class="quiz-wrapper">
            <h2>Quiz</h2>
            <div class="quizzes">
                <div class="quiz">
                    <div class="quiz-info">
                        <h3>Quiz 1</h3>
                    </div>
                    <div class="view-button">
                        <a href="../html/student-quizDesc.html">
                            <button type="submit">View</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="view-more">
                <a href="../html/student-viewQuiz.html">
                    <p>View More</p>
                    <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>

        <!-- learning material -->
        <div class="material-wrapper">
            <h2>Learning Material</h2>
            <div class="materials">
                <div class="learning-material">
                    <div class="learning-info">
                        <h3>Learning Material 1</h3>
                    </div>
                    <div class="view-button">
                        <a href="../html/student-learning.html" target="_blank">
                            <button type="submit">View</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="view-more">
                <a href="../html/student-viewLearning.html">
                    <p>View More</p>
                    <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>

        <!-- Progress Tracker -->
        <div class="tracker-wrapper">
            <h2>Progress Tracker</h2>
            <div class="progress">
                <table>
                    <tr>
                        <th class="no-title">No</th>
                        <th class="name-title">Class Name</th>
                        <th class="quiz-title">Quiz</th>
                        <th class="status-title">Status</th>
                    </tr>
                    <tr>
                        <td>1</td>
                        <td>Physic</td>
                        <td>Quiz 1</td>
                        <td>Not completed</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Chemistry</td>
                        <td>Quiz 2</td>
                        <td>Not completed</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>English</td>
                        <td>Quiz 1</td>
                        <td>Not completed</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Networking</td>
                        <td>Quiz 4</td>
                        <td>Not completed</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Math</td>
                        <td>Quiz 2</td>
                        <td>Not completed</td>
                    </tr>
                </table>
            </div>
            <div class="view-more">
                <a href="../html/student-progressTracker.html">
                    <p>View More</p>
                    <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>

        <!-- Gamification -->
        <div class="gamification-wrapper">
            <h2>Gamification</h2>
            <div class="all-gamification">
                <div class="gamification">
                    <div class="gamification-info">
                        <img src="../picture/G1.png" />
                        <h3>Quiz Master</h3>
                        <p>Get the quiz all correct</p>
                        <h3>5</h3>
                    </div>
                </div>
                <div class="gamification">
                    <div class="gamification-info">
                        <img src="../picture/G2.png" />
                        <h3>Quick learner</h3>
                        <p>Answer quiz 75% correctly but not 100%</p>
                        <h3>0</h3>
                    </div>
                </div>
                <div class="gamification">
                    <div class="gamification-info">
                        <img src="../picture/G3.png" />
                        <h3>The lost lamb</h3>
                        <p>Answer quiz 25% correctly</p>
                        <h3>0</h3>
                    </div>
                </div>
                <div class="gamification">
                    <div class="gamification-info">
                        <img src="../picture/G4.png" />
                        <h3>Goals!</h3>
                        <p>Answer 5 questions correctly in a row</p>
                        <h3>1</h3>
                    </div>
                </div>
                <div class="gamification">
                    <div class="gamification-info">
                        <img src="../picture/G5.png" />
                        <h3>Hardworking</h3>
                        <p>Done every 10 quiz</p>
                        <h3>0</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>