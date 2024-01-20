<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

$classCode = '';
$className = '';
$students = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['studentID'])) {

	$classCode = mysqli_real_escape_string($connection, $_GET['studentID']);

    // query for class details
    $classQuery = "SELECT * FROM tblclass WHERE classid = '$classCode'";
    $classResult = mysqli_query($connection, $classQuery);

    if ($classRow = mysqli_fetch_assoc($classResult)) {
        $className = $classRow['classname'];

        // Retrieve enrolled students' details
        $studentsQuery = "
            SELECT s.studentid, s.fname, s.lname, s.email, s.dob, s.country, s.gender
            FROM tblstudents s
            JOIN tblenrollment e ON s.studentid = e.studentid
            WHERE e.classid = '$classCode'
        ";
        $studentsResult = mysqli_query($connection, $studentsQuery);

        while ($studentRow = mysqli_fetch_assoc($studentsResult)) {
            $students[] = $studentRow;
        }
    } else {
        echo '<script>alert("No class found with the provided class code.");</script>';
    }
}

// Always close the connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Progress Tracker</title>

    <link rel="stylesheet" href="../css/teacher-viewClassroom.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>

    <!-- content -->
    <div class="wrapper">
        <div class="header">
            <h1>View Classroom</h1>
        </div>
        <div class="filter-section">
            <h2>Search by:</h2>
            <div class="filter">
                <form action="">
                    <h3>Class Code:</h3>
                    <input type="text" name="studentID" id="studentID" placeholder="Enter Class Code" />
                    <div class="button-container">
                        <button type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="details">
            <h2>Classroom Details:</h2>
            <div class="details-container">
                <div class="details-left">
                    <h3>Class Code:</h3>
                    <h3>Class Name:</h3>
                </div>
                <div class="details-right">
                    <h3><?php echo htmlspecialchars($classCode); ?></h3>
                    <h3><?php echo htmlspecialchars($className); ?></h3>
                </div>
            </div>
        </div>
        <div class="tablelist">
            <table>
                <tr>
                    <th class="student-id">Student ID</th>
                    <th class="student-name">Student Name</th>
                    <th class="email">Email</th>
                    <th class="dob">Date of Born</th>
                    <th class="country">Country</th>
                    <th class="gender">Gender</th>
                </tr>
                <?php foreach ($students as $student): ?>
                <tr>
                    <td><?php echo htmlspecialchars($student['studentid']); ?></td>
                    <td><?php echo htmlspecialchars($student['fname'] . ' ' . $student['lname']); ?></td>
                    <td><?php echo htmlspecialchars($student['email']); ?></td>
                    <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($student['dob']))); ?></td>
                    <td><?php echo htmlspecialchars($student['country']); ?></td>
                    <td><?php echo htmlspecialchars($student['gender']); ?></td>
                </tr>
                <?php endforeach; ?>

                <?php if (empty($students)): ?>
                <tr>
                    <td colspan="7">No records found.</td>
                </tr>
                <?php endif; ?>

            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>