<?php
include "connection.php";
include_once "session-check.php";

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

    <link rel="stylesheet" href="../css/student-studentDashboard.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>











    <!-- classroom -->
    <div class="header">
        <div class="img-container">
            <img src="../picture/header_student.png" />
        </div>
    </div>
    </div>
    <div class="search">
        <form action="" method="post">
            <h1>Join A Class</h1>
            <div class="search-container">
                <i class="bx bx-search"></i>
                <input type="text" placeholder="Enter Class Code" name="classCode" required />
            </div>
            <div class="button-container">
                <input type="submit" value="Join" name="txtJoin"></input>
                <a href=" #">
                    <button type="button">My Classroom</button>
                </a>
            </div>
        </form>
    </div>

    <?php
    if(isset($_POST['txtJoin'])){
        include "connection.php";
        $classCode = $_POST['classCode'];
        $studentId = $_SESSION['studentid'];

        // step 2: create the sql commands
        $query = "SELECT classid FROM tblclass WHERE classid = '{$classCode}'";

        // Step 3: Execute the query
        $result = mysqli_query($connection, $query);

        // Step 4: Read the results
        // If the class exists
        if($result && mysqli_num_rows($result) > 0) {
            $classRow = mysqli_fetch_assoc($result);
            $classId = $classRow['classid'];

            // Check if the student is already joined in the class
            $enrollmentCheck = "SELECT * FROM tblenrollment WHERE studentid = '$studentId' AND classid = '$classId'";
            $enrollmentResult = mysqli_query($connection, $enrollmentCheck);

            // If not yet joined the class, insert the student into the class
            if(mysqli_num_rows($enrollmentResult) == 0) {
                $enrollQuery = "INSERT INTO tblenrollment (studentid, classid) VALUES ('$studentId', '$classId')";
                $enrollResult = mysqli_query($connection, $enrollQuery);
                if($enrollResult) {
                    echo "<script>alert('Successfully joined the class.')</script>";
                } else {
                    echo "<script>alert('Error joining the class.')</script>";
                }
            } else {
                echo "<script>alert('You are already joined in this class.')</script>";
            }
        } else {
            echo "<script>alert('Invalid class code.')</script>";
        }

        // Close the connection
        mysqli_close($connection);
    }
    ?>










    <div class="content">
        <!-- quiz -->
        <div class="quiz-wrapper">
            <h2>Quiz</h2>
            <div class="quizzes">

                <?php
                include "connection.php";
                $studentId = $_SESSION['studentid'];

                // step 2: create the sql commands
                $query = "SELECT q.quizid, q.quizname, c.classname, q.creationdate 
                        FROM tblquiz q
                        INNER JOIN tblenrollment e ON q.classid = e.classid
                        INNER JOIN tblclass c ON q.classid = c.classid
                        WHERE e.studentid = '{$studentId}'
                        ORDER BY q.creationdate DESC
                        LIMIT 4";

                // Step 3: Execute the query
                $result = mysqli_query($connection, $query);

                // Step 4: Read the results
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo
                        '<div class="quiz">
                            <div class="quiz-info">
                                <h3>' . htmlspecialchars($row['quizname']) . '</h3>
                                <h4>' . htmlspecialchars($row['classname']) . '</h4>
                            </div>
                            <div class="view-button">
                                <a href="../php/student-quizDesc.php?quizid=' . urlencode($row['quizid']) . '">
                                    <button type="submit">View</button>
                                </a>
                            </div>
                        </div>';
                    }
                } else {
                    // If no quizzes are found, show the message
                    echo 
                    '<div class="quiz">
                        <div class="quiz-info">
                            <h3>No quizzes available at the moment.</h3>
                        </div>
                    </div>';
                }

                // Step 5: Close the connection
                mysqli_close($connection);
                ?>

            </div>

            <div class="view-more">
                <a href="../php/student-viewQuiz.php">
                    <p>View More</p>
                    <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>










        <!-- learning material -->
        <div class="material-wrapper">
            <h2>Learning Material</h2>
            <div class="materials">

                <?php
                include "connection.php";
                $studentId = $_SESSION['studentid'];

                // step 2: create the sql commands
                $query = "SELECT lm.lmid, lm.lmname, lm.creationdate, c.classname 
                        FROM tbllm lm
                        INNER JOIN tblenrollment e ON lm.classid = e.classid
                        INNER JOIN tblclass c ON lm.classid = c.classid
                        WHERE e.studentid = '{$studentId}'
                        ORDER BY lm.creationdate DESC
                        LIMIT 4";

                // Step 3: Execute the query
                $result = mysqli_query($connection, $query);

                // Step 4: Read the results
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="learning-material">
                                <div class="learning-info">
                                    <h3>' . htmlspecialchars($row['lmname']) . '</h3>
                                    <h4>' . htmlspecialchars($row['classname']) . '</h4>
                                </div>
                                <div class="view-button">
                                    <a href="../php/student-learning.php?lmid=' . urlencode($row['lmid']) . '" target="_blank">
                                        <button type="button">View</button>
                                    </a>
                                </div>
                            </div>';
                    }

                } else {
                    // If no learning materials are found, show the message
                    echo '<div class="learning-material">
                            <div class="learning-info">
                                <h3>No learning materials available at the moment.</h3>
                            </div>
                        </div>';
                }

                // Step 5: Close the connection
                mysqli_close($connection);
                ?>

            </div>

            <div class="view-more">
                <a href="../php/student-viewLearning.php">
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

                    <?php
                    include "connection.php";
                    $studentId = $_SESSION['studentid'];

                    // step 2: create the sql commands
                    $query = "SELECT q.quizid, q.quizname, c.classname, p.status 
                            FROM tblprogress p
                            INNER JOIN tblquiz q ON p.quizid = q.quizid
                            INNER JOIN tblenrollment e ON q.classid = e.classid
                            INNER JOIN tblclass c ON q.classid = c.classid
                            WHERE e.studentid = '{$studentId}'
                            ORDER BY p.attemptdate DESC, q.creationdate DESC
                            LIMIT 5";


                    // Step 3: Execute the query
                    $result = mysqli_query($connection, $query);

                    // Step 4: Read the results
                    if (mysqli_num_rows($result) > 0) {
                        $index = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                        echo 
                        '<tr>
                            <td>' . $index++ . '</td>
                            <td>' . htmlspecialchars($row['classname']) . '</td>
                            <td>' . htmlspecialchars($row['quizname']) . '</td>
                            <td>' . htmlspecialchars($row['status']) . '</td>
                        </tr>';
                        }
                    } else {
                        echo 
                        '<tr>
                            <td colspan="4">No progress records found.</td>
                        </tr>';
                    }
                    
                    // Step 4: Close the connection
                    mysqli_close($connection);
                    ?>

                </table>
            </div>
            <div class="view-more">
                <a href="../php/student-progressTracker.php">
                    <p>View More</p>
                    <i class="bx bx-right-arrow-alt"></i>
                </a>
            </div>
        </div>











        <!-- Gamification -->
        <div class="gamification-wrapper">
            <h2>Gamification</h2>
            <div class="all-gamification">

                <?php
                include "connection.php";
                $studentId = $_SESSION['studentid'];

                // step 2: create the sql commands
                $query = "SELECT g.badgeid, g.badgename, g.description, IFNULL(a.collectionnum, 0) AS collectionnum
                FROM tblgame g
                LEFT JOIN tblaward a ON g.badgeid = a.badgeid AND a.studentid = '{$studentId}'
                ORDER BY g.badgeid";

                // Step 3: Execute the query
                $result = mysqli_query($connection, $query);

                // Step 4: Read the results
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                        $badgeImagePath = "../picture/G" . htmlspecialchars($row['badgeid']) . ".png";

                        echo 
                        '<div class="gamification">
                            <div class="gamification-info">
                                <img src="' . $badgeImagePath . '" />
                                <h3>' . htmlspecialchars($row['badgename']) . '</h3>
                                <p>' . htmlspecialchars($row['description']) . '</p>
                                <h3>' . htmlspecialchars($row['collectionnum']) . '</h3>
                            </div>
                        </div>';
                    }
                } else {
                    // If no quizzes are found, show a message
                    echo 
                    '<div class="gamification">
                        <div class="gamification-info">
                            <h3>Sorry, gamification feature is under development/maintenance.</h3>
                        </div>
                    </div>';
                }
                ?>

            </div>
        </div>
    </div>











    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>