<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BreezeQuiz</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/user-index.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-user-nav.php'; ?>

    <!-- introduction -->
    <div class="banner">
        <div class="content">
            <h1>BreezeQuiz</h1>
            <p>
                An interactive quiz platform for enhanced learning and
                teaching.
            </p>
        </div>
    </div>
    <div class="intro">
        <h1>
            Sign up with us for a chance <br />to excel and innovate.
            <br /><br />Start your success journey today!
        </h1>
        <div class="button-wrap">
            <a href="../php/user-register.php" target="_blank">
                <button class="intro-btn">Sign Up</button>
            </a>
            <a href="../php/user-login.php" target="_blank">
                <span class="button-wrap2">
                    <button class="intro-btn">Log In</button>
                </span>
            </a>
        </div>
    </div>

    <!-- feature -->
    <div class="feature">
        <h2 class="feature-title">Our Feature</h2>
        <div class="feature-container">
            <div class="feature-box">
                <img src="../picture/pen1.png" />
                <h3>Interactive</h3>
                <p>Interactive <br />and engaging.</p>
            </div>
            <div class="feature-box">
                <img src="../picture/pen2.png" />
                <h3>Easy to Use</h3>
                <p>Easy to Use and Navigate.</p>
            </div>
            <div class="feature-box">
                <img src="../picture/pen3.png" />
                <h3>Fun</h3>
                <p>Fun and Engaging for Users</p>
            </div>
            <div class="feature-box">
                <img src="../picture/pen4.png" />
                <h3>Study</h3>
                <p>Enhanced Learning and Effective Teaching.</p>
            </div>
        </div>
    </div>

    <!-- role responsibilities -->
    <div class="role">
        <div class="student">
            <div class="student-text">
                <h2>Student Role</h2>
                <p>
                    Enhance your learning experience with our interactive
                    quiz platform.
                </p>
                <ul>
                    <li>
                        Engage with interactive quizzes and assessments.
                    </li>
                    <li>Receive instant feedback to aid learning.</li>
                    <li>Earn badges and compete on leaderboards.</li>
                    <li>
                        Access a comprehensive resource library for study
                        materials.
                    </li>
                </ul>
            </div>
        </div>
        <div class="teacher">
            <div class="teacher-text">
                <h2>Teacher Role</h2>
                <p>
                    Enhance your teaching experience with our interactive
                    quiz platform.
                </p>
                <ul>
                    <li>Create interactive quizzes and assessments.</li>
                    <li>Receive instant feedback to aid teaching.</li>
                    <li>Track student progress and performance.</li>
                    <li>
                        Access a comprehensive resource library for study
                        materials.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>

</body>

</html>