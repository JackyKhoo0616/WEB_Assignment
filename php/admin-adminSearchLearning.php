<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['admin']);

$materials = [];

// Search functionality
if (isset($_POST['btn-search'])) {
    $lmId = $_POST['lmId'] ?? '';
    $classId = $_POST['classId'] ?? '';
    $materialNameStartsWith = $_POST['materialNameStartsWith'] ?? 'all';

    // Build the query
    $query = "SELECT lm.lmid, lm.lmname, lm.classid, c.classname, t.fname, t.lname, lm.creationdate
			FROM tbllm lm
			JOIN tblclass c ON lm.classid = c.classid
			JOIN tblteachers t ON c.teacherid = t.teacherid
			WHERE 1";

    if ($lmId !== '') {
        $query .= " AND lm.lmid = '".mysqli_real_escape_string($connection, $lmId)."'";
    }

    if ($classId !== '') {
        $query .= " AND lm.classid = '".mysqli_real_escape_string($connection, $classId)."'";
    }

    if ($materialNameStartsWith !== 'all') {
        if ($materialNameStartsWith === '#') {
            $query .= " AND lm.lmname REGEXP '^[^a-zA-Z]'";
        } else {
            $query .= " AND lm.lmname LIKE '" . mysqli_real_escape_string($connection, $materialNameStartsWith) . "%'";
        }
    }

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Fetch the results
    if ($result) {
        $materials = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
}

// Delete functionality
if (isset($_POST['btn-delete'])) {
    $lmidToDelete = $_POST['lmidToDelete'] ?? '';

    if ($lmidToDelete !== '') {
        // Delete query
        $deleteQuery = "DELETE FROM tbllm WHERE lmid = '".mysqli_real_escape_string($connection, $lmidToDelete)."'";
        mysqli_query($connection, $deleteQuery);

        if (mysqli_affected_rows($connection) > 0) {
            echo "<script>alert('Learning material deleted successfully.')</script>";
        } else {
            echo "<script>alert('No learning material found with ID: $lmidToDelete')</script>";
        }
    }
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learning Material Information</title>

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/admin-adminSearchLearning.css" />
</head>

<body>
    <div class="wrapper">
        <h1>Learning Material Information</h1>
        <div class="search-bar">
            <form action="" method="post">
                <input type="text" name="lmId" placeholder="Learning Material ID" />
                <input type="text" name="classId" placeholder="Class ID" />
                <select name="materialNameStartsWith" id="quiz">
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

                <input type="submit" name="btn-reset" value="Reset" />
                <input type="submit" name="btn-search" value="Search" />
            </form>
        </div>
        <div class="result">
            <table>
                <tr>
                    <th class="lm-id">LM ID</th>
                    <th class="lmname">Learning Material Name</th>
                    <th class="classid">Class ID</th>
                    <th class="classname">Class Name</th>
                    <th class="teacher">Teacher Name</th>
                    <th class="date">Creation Date</th>
                    <th class="btn"></th>
                </tr>
                <?php foreach ($materials as $lm): ?>
                <tr>
                    <form method="post">
                        <td><?php echo htmlspecialchars($lm['lmid']); ?></td>
                        <td><?php echo htmlspecialchars($lm['lmname']); ?></td>
                        <td><?php echo htmlspecialchars($lm['classid']); ?></td>
                        <td><?php echo htmlspecialchars($lm['classname']); ?></td>
                        <td><?php echo htmlspecialchars($lm['fname'] . ' ' . $lm['lname']); ?></td>
                        <td><?php echo htmlspecialchars($lm['creationdate']); ?></td>
                        <td>
                            <input type="hidden" name="lmidToDelete"
                                value="<?php echo htmlspecialchars($lm['lmid']); ?>" />
                            <input type="submit" name="btn-delete" value="Delete"
                                onclick="return confirm('Are you sure?');" />
                        </td>
                    </form>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <div class="copyright">
        <p>© 2024 BreezeQuiz. All rights reserved.</p>
    </div>
</body>

</html>