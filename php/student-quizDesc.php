<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiz</title>

    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />
    <link rel="stylesheet" href="../css/student-quizDesc.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />

    <script src="../javascript/backBtnLogic.js"></script>
</head>

<body>
    <!-- navigational bar -->
    <div class="banner">
        <div class="navbar">
            <a href="../html/student-studentDashboard.html">
                <img src="../picture/logo.png" class="logo" />
            </a>
            <ul>
                <li><a href="../html/student-viewQuiz.html">Quiz</a></li>
                <li>
                    <a href="../html/student-viewLearning.html">Learning Material</a>
                </li>
                <li>
                    <a href="../html/student-progressTracker.html">Progress Tracker</a>
                </li>
                <li class="no-a">
                    Other Pages<i class="bx bxs-chevron-down"></i>

                    <div class="sub-menu">
                        <ul>
                            <li>
                                <a href="../html/student-aboutUs.html">About Us</a>
                            </li>
                            <li><a href="#">Educational Regulation</a></li>
                            <li><a href="#">Data Privacy Law</a></li>
                        </ul>
                    </div>
                </li>
                <li class="no-a">
                    Wilson<i class="bx bxs-chevron-down"></i>

                    <div class="sub-menu">
                        <ul>
                            <li><a href="#">Profile</a></li>
                            <li>
                                <a href="../html/user-index.html">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="main">
        <h1>Quiz 1</h1>
        <div class="quiz-info">
            <table>
                <tr>
                    <th>Quiz Status</th>
                    <td>No attempt</td>
                </tr>
                <tr>
                    <th>Creation Date</th>
                    <td>11 January 2024</td>
                </tr>
                <tr>
                    <th>Marks</th>
                    <td>-</td>
                </tr>
            </table>
        </div>
        <div class="quiz-button">
            <div class="back-button">
                <a href="../html/student-viewQuiz.html">
                    <button type="submit">Back</button>
                </a>
            </div>
            <div class="start-button">
                <a href="../html/student-answerQuiz.html">
                    <button type="submit">Start Quiz</button>
                </a>
            </div>
        </div>
    </div>

    <!-- copyright part -->
    <div class="copyright">
        <p>© 2024 BreezeQuiz. All rights reserved.</p>
    </div>
</body>

</html>