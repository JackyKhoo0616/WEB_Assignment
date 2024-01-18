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
    <link rel="stylesheet" href="../javascript/scrollRemain.js" />
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
        <form action="#" method="post">
            <h1>Join A Class</h1>
            <div class="search-container">
                <i class="bx bx-search"></i>
                <input type="text" placeholder="Enter Class Code" name="classCode" required />
            </div>
            <div class="button-container">
                <input type="submit" value="Join" name="txtSubmit" />
            </div>

            <?php

            // Check if the form is submitted
            if (isset($_POST['txtSubmit'])) {
                // Get the class ID from the form
                $classid = $_POST['classCode'];

                // Check if the class exists
                $stmt = mysqli_prepare($connection, "SELECT classid FROM tblclass WHERE classid = ?");
                mysqli_stmt_bind_param($stmt, "i", $classid);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $classid);
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) > 0) {
                    mysqli_stmt_fetch($stmt);
                    mysqli_stmt_close($stmt);

                    // Class exists, now check if the student is already enrolled
                    $studentid = $_SESSION['studentid']; // The student ID should be stored in the session

                    $checkEnrollment = mysqli_prepare($connection, "SELECT * FROM tblenrollment WHERE studentid = ? AND classid = ?");
                    mysqli_stmt_bind_param($checkEnrollment, "ii", $studentid, $classid);
                    mysqli_stmt_execute($checkEnrollment);
                    mysqli_stmt_store_result($checkEnrollment);

                    if (mysqli_stmt_num_rows($checkEnrollment) == 0) {
                        // Student is not enrolled, proceed with enrollment
                        $insertStmt = mysqli_prepare($connection, "INSERT INTO tblenrollment (studentid, classid) VALUES (?, ?)");
                        mysqli_stmt_bind_param($insertStmt, "ii", $studentid, $classid);
                        mysqli_stmt_execute($insertStmt);

                        if (mysqli_stmt_affected_rows($insertStmt) > 0) {
                            echo '<script>alert("You have successfully joined the class!");</script>';

                        } else {
                            echo '<script>alert("Failed to join the class. Please try again.");</script>';
                        }
                        
                        mysqli_stmt_close($insertStmt);
                        
                    } else {
                        echo '<script>alert("You are already enrolled in this class.");</script>';
                    }
                    mysqli_stmt_close($checkEnrollment);
                } else {
                    echo '<script>alert("No such class exists.");</script>';
                }
                mysqli_close($connection);
            }
            ?>
        </form>
    </div>

    <div class="content">

        <!-- quiz -->
        <div class="quiz-wrapper">
            <h2>Quiz</h2>
            <div class="quizzes">

                <?php

                // get the student ID from the session
                $studentId = $_SESSION['studentid'];

                // SQL query to retrieve up to 4 quizzes for classes the student is enrolled in
                $query = "SELECT q.quizid, q.quizname, c.classname, q.creationdate
                        FROM tblquiz q
                        JOIN tblenrollment e ON q.classid = e.classid
                        JOIN tblclass c ON q.classid = c.classid
                        WHERE e.studentid = ?
                        ORDER BY q.creationdate ASC
                        LIMIT 4";

                $quizzesFound = false; // Flag to track if any quizzes have been found

                if ($stmt = mysqli_prepare($connection, $query)) {
                    mysqli_stmt_bind_param($stmt, "i", $studentId);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_bind_result($stmt, $quizId, $quizName, $className, $creationDate);

                    while (mysqli_stmt_fetch($stmt)) {
                        $quizzesFound = true; // Set the flag to true as we found a quiz

                        // Output the HTML structure for each quiz
                        echo '<div class="quiz">
                                <div class="quiz-info">
                                    <h3>' . htmlspecialchars($quizName) . '</h3>
                                    <h4>' . htmlspecialchars($className) . '</h4>
                                </div>
                                <div class="view-button">
                                    <a href="../php/student-quizDesc.php?quizid=' . urlencode($quizId) . '">
                                        <button type="submit">View</button>
                                    </a>
                                </div>
                            </div>';
                    }

                    mysqli_stmt_close($stmt);

                    if (!$quizzesFound) {
                        // No quizzes were found
                        echo '<div class="quiz">
                                <div class="quiz-info">
                                    <h3>No quizzes available at the moment.</h3>
                                </div>
                            </div>';
                    }
                } else {
                    echo "SQL Error: " . mysqli_error($connection);
                }

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

                // get the student ID from the session
                $studentId = $_SESSION['studentid'];

                // SQL query to fetch learning materials for classes in which the student is enrolled
                $query = "SELECT lm.lmid, lm.lmname, lm.creationdate, c.classname 
                        FROM tbllm lm
                        INNER JOIN tblclass c ON lm.classid = c.classid
                        INNER JOIN tblenrollment e ON lm.classid = e.classid
                        WHERE e.studentid = ?
                        ORDER BY lm.creationdate ASC
                        LIMIT 4";

                // Prepare the statement
                if ($stmt = mysqli_prepare($connection, $query)) {
                    // Bind the student ID to the statement
                    mysqli_stmt_bind_param($stmt, "i", $studentId);

                    // Execute the query
                    mysqli_stmt_execute($stmt);

                    // Bind the result variables
                    mysqli_stmt_bind_result($stmt, $lmid, $lmname, $creationdate, $classname);

                    // Flag to check if learning materials are available
                    $hasLearningMaterials = false;

                    // Fetch values
                    while (mysqli_stmt_fetch($stmt)) {
                        
                        $hasLearningMaterials = true;
                        echo '<div class="learning-material">
                                <div class="learning-info">
                                    <h3>' . htmlspecialchars($lmname) . '</h3>
                                    <h4>' . htmlspecialchars($classname) . '</h4>
                                </div>
                                <div class="view-button">
                                    <a href="../php/student-learning.php?lmid=' . urlencode($lmid) . '" target="_blank">
                                        <button type="button">View</button>
                                    </a>
                                </div>
                            </div>';
                    }

                    // If no learning materials are available, display a message
                    if (!$hasLearningMaterials) {
                        echo '<div class="learning-material">
                                <div class="learning-info">
                                    <h3>No learning material available at the moment.</h3>
                                </div>
                            </div>';
                    }

                    // Close the statement
                    mysqli_stmt_close($stmt);
                
                } else {
                    echo "SQL Error: " . mysqli_error($connection);
                }

                // Close the database connection
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

        <?php
        include "connection.php";

        $studentId = $_SESSION['studentid'];

        $query = "SELECT p.studentid, p.quizid, p.status, p.marks, p.date, c.classname, q.quizname
                FROM tblprogress p
                JOIN tblquiz q ON p.quizid = q.quizid
                JOIN tblclass c ON q.classid = c.classid
                WHERE p.studentid = ?
                ORDER BY p.date DESC LIMIT 5";

        $progressRecords = [];

        if ($stmt = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($stmt, "i", $studentId);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $studentid, $quizid, $status, $marks, $date, $classname, $quizname);

            while (mysqli_stmt_fetch($stmt)) {
                $progressRecords[] = [
                    'classname' => $classname,
                    'quizname' => $quizname,
                    'status' => $status
                ];
            }
            mysqli_stmt_close($stmt);
            
        } else {
            echo "SQL Error: " . htmlspecialchars(mysqli_error($connection));
        }

        mysqli_close($connection);
        ?>

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

                    <?php if (!empty($progressRecords)): ?>
                    <?php foreach ($progressRecords as $index => $record): ?>

                    <tr>
                        <td><?php echo ($index + 1); ?></td>
                        <td><?php echo htmlspecialchars($record['classname']); ?></td>
                        <td><?php echo htmlspecialchars($record['quizname']); ?></td>
                        <td><?php echo htmlspecialchars($record['status']); ?></td>
                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>

                    <tr>
                        <td colspan="4">No progress records found.</td>
                    </tr>

                    <?php endif; ?>

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