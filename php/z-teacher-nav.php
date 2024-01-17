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
</body>

</html>