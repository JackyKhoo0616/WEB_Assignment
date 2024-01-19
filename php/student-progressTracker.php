<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

// Initialize an array to hold the progress records
$progressRecords = [];

// Check if the form has been submitted
if (isset($_POST['btnSubmit'])) {
    $classId = $_POST['txtclassid'] ?? ''; // Get the class code from the form
    $quizFirstChar = $_POST['quiz'] ?? 'all'; // Get the selected quiz character from the form

    // Start the query
    $query = "SELECT p.date, p.status, p.marks, q.quizname, c.classname, c.classid 
              FROM tblprogress p
              JOIN tblquiz q ON p.quizid = q.quizid
              JOIN tblclass c ON q.classid = c.classid
              WHERE p.studentid = ?";

    // Add class ID filter to the query if provided
    if (!empty($classId)) {
        $query .= " AND c.classid = ?";
    }

    // Add quiz name filter to the query if a letter is chosen
    if ($quizFirstChar !== 'all') {
        $query .= " AND q.quizname LIKE ?";
    }

    $query .= " ORDER BY p.date DESC"; // Order the results by date

    // Prepare the statement
    if ($stmt = mysqli_prepare($connection, $query)) {
        // Bind parameters based on what filters are set
        if (!empty($classId) && $quizFirstChar !== 'all') {
            $quizFirstChar = $quizFirstChar . '%';
            mysqli_stmt_bind_param($stmt, "iis", $_SESSION['studentid'], $classId, $quizFirstChar);
        } elseif (!empty($classId)) {
            mysqli_stmt_bind_param($stmt, "ii", $_SESSION['studentid'], $classId);
        } elseif ($quizFirstChar !== 'all') {
            $quizFirstChar = $quizFirstChar . '%';
            mysqli_stmt_bind_param($stmt, "is", $_SESSION['studentid'], $quizFirstChar);
        } else {
            mysqli_stmt_bind_param($stmt, "i", $_SESSION['studentid']);
        }

        // Execute the query
        mysqli_stmt_execute($stmt);

        // Bind the result variables
        mysqli_stmt_bind_result($stmt, $date, $status, $marks, $quizname, $classname, $classid);

        // Fetch the results
        while (mysqli_stmt_fetch($stmt)) {
            $progressRecords[] = [
                'date' => $date,
                'status' => $status,
                'marks' => $marks,
                'quizname' => $quizname,
                'classname' => $classname,
                'classid' => $classid
            ];
        }

        mysqli_stmt_close($stmt);
    } else {
        // Handle errors with the query
        echo "SQL Error: " . htmlspecialchars(mysqli_error($connection));
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progress Tracker</title>

    <link rel="stylesheet" href="../css/student-progressTracker.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <style>
    .filter input[type="text"] {
        width: 500px;
        height: 40px;
        border-radius: 5px;
        border: none;
        outline: none;
        margin: 20px;
        padding-left: 10px;
        font-size: 15px;
    }

    .filter input[type="submit"] {
        width: 100px;
        height: 40px;
        border-radius: 5px;
        border: none;
        outline: none;
        margin-left: 60px;
        font-size: 20px;
        font-weight: bold;
        background-color: #c8633d;
        color: #fff;
        cursor: pointer;
        align-self: baseline;
    }

    .filter input[type="submit"]:hover {
        background-color: #fff;
        color: #c8633d;
        transition: 0.3s;
    }
    </style>
</head>

<body>
    <!-- navigational bar -->
    <?php include '../php/z-student-nav.php'; ?>

    <!-- content -->
    <div class="wrapper">
        <div class="header">
            <h1>Progress Tracker</h1>
        </div>
        <form action="#" method=post>
            <div class="filter-section">
                <h2>Filter by:</h2>
                <div class="filter">
                    <h3>Class Code:</h3>
                    <input type="text" name="txtclassid" id="txtclassid" placeholder="Enter Class Code">
                    <h3>Quiz Name:</h3>
                    <select name="quiz" id="quiz">
                        <option value="all">All</option>
                        <option value="a">A</option>
                        <option value="b">B</option>
                        <option value="c">C</option>
                        <option value="d">D</option>
                        <option value="e">E</option>
                        <option value="f">F</option>
                        <option value="g">G</option>
                        <option value="h">H</option>
                        <option value="i">I</option>
                        <option value="j">J</option>
                        <option value="k">K</option>
                        <option value="l">L</option>
                        <option value="m">M</option>
                        <option value="n">N</option>
                        <option value="o">O</option>
                        <option value="p">P</option>
                        <option value="q">Q</option>
                        <option value="r">R</option>
                        <option value="s">S</option>
                        <option value="t">T</option>
                        <option value="u">U</option>
                        <option value="v">V</option>
                        <option value="w">W</option>
                        <option value="x">X</option>
                        <option value="y">Y</option>
                        <option value="z">Z</option>
                        <option value="#">Z</option>
                    </select>
                    <input type="submit" name="btnSubmit" value="Submit">
                </div>
            </div>
        </form>
        <div class=" tracker">
            <table>
                <tr>
                    <th>Class Code</th>
                    <th>Class Name</th>
                    <th>Quiz Name</th>
                    <th>Status</th>
                </tr>

                <?php foreach ($progressRecords as $index => $record): ?>

                <tr>
                    <td><?php echo htmlspecialchars($record['classid']); ?></td>
                    <td><?php echo htmlspecialchars($record['classname']); ?></td>
                    <td><?php echo htmlspecialchars($record['quizname']); ?></td>
                    <td><?php echo htmlspecialchars($record['status']); ?></td>
                </tr>

                <?php endforeach; ?>
                <?php if (empty($progressRecords)): ?>

                <tr>
                    <td colspan="4">No records found.</td>
                </tr>

                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>