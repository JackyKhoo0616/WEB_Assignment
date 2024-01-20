<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

// store the progress records
$progressRecords = [];

$studentId = $_SESSION['studentid'];

// Check if the form has been submitted
if (isset($_POST['btnSubmit'])) {
    $classIdFilter = $_POST['txtclassid'] ?? '';
    $quizNameFilter = $_POST['quiz'] ?? 'all';

    // SQL to get the student's classes
    $enrolledClassesQuery = "SELECT classid FROM tblenrollment WHERE studentid = '{$studentId}'";
    $enrolledClassesResult = mysqli_query($connection, $enrolledClassesQuery);
    $enrolledClasses = [];
    while ($classRow = mysqli_fetch_assoc($enrolledClassesResult)) {
        $enrolledClasses[] = $classRow['classid'];
    }

    // SQL to get the progress records
    $progressQuery = "SELECT p.*, c.classname, c.classid, q.quizname, COUNT(tq.questionnum) as totalQuestions
                    FROM tblprogress p
                    JOIN tblquiz q ON p.quizid = q.quizid
                    JOIN tblclass c ON q.classid = c.classid
                    LEFT JOIN tblquestion tq ON q.quizid = tq.quizid
                    WHERE p.studentid = '{$studentId}'
                    AND q.classid IN ('" . implode("','", $enrolledClasses) . "')
                    GROUP BY q.quizid, p.attemptdate, p.marks, c.classname, c.classid, q.quizname";
                    
    // class ID filter
    if (!empty($classIdFilter)) {
        $progressQuery .= " AND q.classid = '{$classIdFilter}'";
    }

    // quiz name filter
    if ($quizNameFilter !== 'all') {
        if ($quizNameFilter === '#') {
            // Filter by quiz names starting with a number or symbol
            $progressQuery .= " AND q.quizname REGEXP '^[0-9].*'";
        } else {
            // Filter by quiz names starting with the selected letter
            $progressQuery .= " AND q.quizname LIKE '{$quizNameFilter}%'";
        }
    }

    $progressResult = mysqli_query($connection, $progressQuery);
    while ($progressRow = mysqli_fetch_assoc($progressResult)) {
        $progressRecords[] = $progressRow;
    }
}
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
                        <option value="#">#</option>
                    </select>
                    <input type="submit" name="btnSubmit" value="Filter">
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
                    <th>Marks</th>
                    <th>Attempt Date</th>
                </tr>

                <?php foreach ($progressRecords as $index => $record): ?>

                <tr>
                    <td><?php echo htmlspecialchars($record['classid']); ?></td>
                    <td><?php echo htmlspecialchars($record['classname']); ?></td>
                    <td><?php echo htmlspecialchars($record['quizname']); ?></td>
                    <td><?php echo htmlspecialchars($record['status']); ?></td>
                    <td>
                        <?php
                        // display "marks/totalQuestions", otherwise "-"
                        echo isset($record['marks']) ? htmlspecialchars($record['marks']) . ' / ' . htmlspecialchars($record['totalQuestions']) : '-';
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($record['attemptdate'] !== NULL ? $record['attemptdate'] : '-'); ?>
                    </td>
                </tr>

                <?php endforeach; ?>

                <?php if (empty($progressRecords)): ?>

                <tr>
                    <td colspan="6">No records found.</td>
                </tr>

                <?php endif; ?>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>