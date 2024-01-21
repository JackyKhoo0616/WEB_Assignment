<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['admin']);

$users = [];

// Check if the search form has been submitted
if (isset($_POST['btn-search'])) {
    $userId = $_POST['userId'] ?? '';
    $userEmail = $_POST['userEmail'] ?? '';
    $country = $_POST['country'] ?? '';
    $role = $_POST['role'] ?? '';

    // Initialize the base query
    $queries = [];

    // Depending on the role, append the appropriate queries
    if ($role == 'all' || $role == 'student') {
        $studentQuery = "SELECT 'Student' as role, studentid as id, fname, lname, email, dob, country, gender FROM tblstudents WHERE 1";
        if (!empty($userId)) {
            $studentQuery .= " AND studentid = '$userId'";
        }
        if (!empty($userEmail)) {
            $studentQuery .= " AND email = '$userEmail'";
        }
        if (!empty($country)) {
            $studentQuery .= " AND country = '$country'";
        }
        $queries[] = $studentQuery;
    }
    if ($role == 'all' || $role == 'teacher') {
        $teacherQuery = "SELECT 'Teacher' as role, teacherid as id, fname, lname, email, dob, country, gender FROM tblteachers WHERE 1";
        if (!empty($userId)) {
            $teacherQuery .= " AND teacherid = '$userId'";
        }
        if (!empty($userEmail)) {
            $teacherQuery .= " AND email = '$userEmail'";
        }
        if (!empty($country)) {
            $teacherQuery .= " AND country = '$country'";
        }
        $queries[] = $teacherQuery;
    }

    // Combine queries for both students and teachers if necessary
    $combinedQuery = implode(' UNION ', $queries);

    // Execute the combined query
    $result = mysqli_query($connection, $combinedQuery);

    // Read the results
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    } else {
        // Handle errors or no results
        echo "No users found or there was an error with the query.";
    }

    // Close the connection
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Information</title>

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/admin-adminSearchUser.css" />
</head>

<body>
    <div class="wrapper">
        <h1>User Information</h1>
        <div class="search-bar">
            <form action="" method="post">
                <input type="text" name="userId" placeholder="User ID" />
                <input type="text" name="userEmail" placeholder="User Email" />
                <select id="role" name="role">
                    <option value="all">All</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                </select>

                <input type="submit" name="btn-reset" value="Reset" />
                <input type="submit" name="btn-search" value="Search" />
            </form>
        </div>
        <div class="result">
            <table>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                </tr>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['fname']); ?></td>
                    <td><?php echo htmlspecialchars($user['lname']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['dob']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>