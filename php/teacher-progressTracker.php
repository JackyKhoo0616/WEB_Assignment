<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

$teacherId = $_SESSION['teacherid'];

$studentIdFilter = $_POST['studentID'] ?? '';
$classIdFilter = $_POST['classID'] ?? '';
$quizFilter = $_POST['quiz'] ?? 'all';

// create query
$query = "SELECT s.studentid, CONCAT(s.fname, ' ', s.lname) AS studentname, c.classid, q.quizname, p.status, p.marks, p.attemptdate
		FROM tblprogress p
		JOIN tblquiz q ON p.quizid = q.quizid
		JOIN tblclass c ON q.classid = c.classid
		JOIN tblstudents s ON p.studentid = s.studentid
		WHERE c.teacherid = '{$teacherId}' ";

// Apply filters based on the form input
if (!empty($studentIdFilter)) {
    $query .= "AND s.studentid = '{$studentIdFilter}' ";
}
if (!empty($classIdFilter)) {
    $query .= "AND c.classid = '{$classIdFilter}' ";
}
if ($quizFilter !== 'all') {
    if ($quizFilter === '#') {
        $query .= "AND q.quizname REGEXP '^[^A-Za-z].*' ";
    } else {
        $query .= "AND q.quizname LIKE '{$quizFilter}%' ";
    }
}

// Complete the query
$query .= "ORDER BY p.attemptdate DESC, q.creationdate DESC";

// Execute the query
$result = mysqli_query($connection, $query);

// Close the connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Performance Monitoring</title>


    <link rel="stylesheet" href="../css/teacher-progressTracker.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>


    <!-- content -->
    <div class="wrapper">
        <div class="header">
            <h1>Performance Monitoring</h1>
        </div>
        <form action="#" method="post">
            <div class="filter-section">
                <h2>Filter by:</h2>
                <div class="filter">
                    <h3>Student ID:</h3>
                    <input type="text" name="studentID" id="studentID" placeholder="Student ID" />
                    <h3>Class Code:</h3>
                    <input type="text" name="classID" id="classID" placeholder="Class ID" />
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
                    <input type="submit" name="btnSubmit" value="Filter" />
                </div>
            </div>
        </form>
        <div class="tracker">
            <table>
                <tr>
                    <th class="student-id">Student ID</th>
                    <th class="student-name">Student Name</th>
                    <th class="class-code">Class Code</th>
                    <th class="quiz-name">Quiz Name</th>
                    <th class="status">Status</th>
                    <th class="marks">Marks</th>
                    <th class="date">Date Attempt</th>
                </tr>

                <?php
				if (isset($result) && mysqli_num_rows($result) > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$displayMarks = $row['status'] === 'No Attempt' ? '-' : htmlspecialchars($row['marks']);
						$displayDate = $row['status'] === 'No Attempt' ? '-' : htmlspecialchars(date('Y-m-d', strtotime($row['attemptdate'])));
						echo "<tr>
								<td>{$row['studentid']}</td>
								<td>{$row['studentname']}</td>
								<td>{$row['classid']}</td>
								<td>{$row['quizname']}</td>
								<td>{$row['status']}</td>
								<td>{$displayMarks}</td>
								<td>{$displayDate}</td>
							</tr>";
					}
				} else {
					echo "<tr><td colspan='7'>No records found.</td></tr>";
				}
				?>

            </table>

        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>