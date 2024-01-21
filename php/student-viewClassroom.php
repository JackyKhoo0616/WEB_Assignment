<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['student']);

$studentId = $_SESSION['studentid'] ?? null; 

if (!$studentId) {
    // student ID isn't in the session
    echo "<script>alert('You must be logged in to view this page.'); window.location.href = 'login.php';</script>";
    exit();
}

// to store the classes
$classes = [];

// Check if the search form has been submitted
$classIdFilter = $_GET['classCode'] ?? '';

// SQL query to get the classes for the student
$query = "SELECT e.classid, cl.classname, CONCAT(t.fname, ' ', t.lname) AS teachername
        FROM tblenrollment e
        JOIN tblclass cl ON e.classid = cl.classid
        JOIN tblteachers t ON cl.teacherid = t.teacherid
        WHERE e.studentid = '{$studentId}'";

if (!empty($classIdFilter)) {
    
    // Apply the filter if a class code was provided
    $query .= " AND e.classid = '{$classIdFilter}'";
}

$query .= " ORDER BY cl.classname ASC"; // Optional: Order the results by class name

$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $classes[] = $row;
    }
}

// close connection 
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>My Classroom</title>

    <link rel="stylesheet" href="../css/student-viewClassroom.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-student-nav.php"; ?>

    <!-- content -->
    <div class="wrapper">
        <div class="header">
            <h1>My Classroom</h1>
        </div>
        <div class="filter-section">
            <h2>Search by:</h2>
            <div class="filter">

                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
                    <h3>Class Code:</h3>
                    <input type="text" name="classCode" id="studentID" placeholder="Enter Class Code"
                        value="<?php echo htmlspecialchars($classIdFilter); ?>" />
                    <div class="button-container">
                        <button type="submit">Search</button>
                    </div>
                </form>

            </div>

            <div class="tablelist">
                <table>
                    <tr>
                        <th class="classcode">Class Code</th>
                        <th class="classname">Class Name</th>
                        <th class="teachername">Teacher Name</th>
                    </tr>

                    <?php if (!empty($classes)): ?>
                    <?php foreach ($classes as $class): ?>

                    <tr>
                        <td class="classcode"><?php echo htmlspecialchars($class['classid']); ?></td>
                        <td class="classname"><?php echo htmlspecialchars($class['classname']); ?></td>
                        <td class="teachername"><?php echo htmlspecialchars($class['teachername']); ?></td>
                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="3">No classes found.</td>
                    </tr>
                    <?php endif; ?>

                </table>
            </div>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>