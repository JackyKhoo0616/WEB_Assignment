<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['admin']);

$quizzes = [];

if (isset($_POST['btn-search'])) {
    // Retrieve search criteria
    $quizId = $_POST['quizId'] ?? '';
    $classId = $_POST['classId'] ?? '';
    $quizNameStartsWith = $_POST['quizNameStartsWith'] ?? '';

    // Build the base query
    $query = "SELECT q.quizid, q.quizname, q.classid, c.classname, t.fname, t.lname, q.creationdate 
			FROM tblquiz q
			JOIN tblclass c ON q.classid = c.classid
			JOIN tblteachers t ON c.teacherid = t.teacherid
			WHERE 1";

    // Add conditions based on search criteria
    if ($quizId !== '') {
        $query .= " AND q.quizid = '" . mysqli_real_escape_string($connection, $quizId) . "'";
    }
    if ($classId !== '') {
        $query .= " AND q.classid = '" . mysqli_real_escape_string($connection, $classId) . "'";
    }
    if ($quizNameStartsWith !== 'all') {
        $query .= $quizNameStartsWith === '#' ?
            " AND q.quizname REGEXP '^[^a-zA-Z]'" :
            " AND q.quizname LIKE '" . mysqli_real_escape_string($connection, $quizNameStartsWith) . "%'";
    }

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Fetch the results
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $quizzes[] = $row;
        }
    }
}

if (isset($_POST['btn-delete'])) {
	$quizIdToDelete = $_POST['quizIdToDelete'] ?? '';

	if ($quizIdToDelete !== '') {
		// Start transaction
		mysqli_begin_transaction($connection);

		// Delete from tblprogress where the quizid matches
		$deleteProgressQuery = "DELETE FROM tblprogress WHERE quizid = '" . mysqli_real_escape_string($connection, $quizIdToDelete) . "'";
		mysqli_query($connection, $deleteProgressQuery);

		// Delete from tblquestion where the quizid matches
		$deleteQuestionsQuery = "DELETE FROM tblquestion WHERE quizid = '" . mysqli_real_escape_string($connection, $quizIdToDelete) . "'";
		mysqli_query($connection, $deleteQuestionsQuery);

		// Delete from tblquiz where the quizid matches
		$deleteQuizQuery = "DELETE FROM tblquiz WHERE quizid = '" . mysqli_real_escape_string($connection, $quizIdToDelete) . "'";
		mysqli_query($connection, $deleteQuizQuery);

		// Check for errors
		if (mysqli_error($connection)) {
			// Rollback transaction
			mysqli_rollback($connection);
			echo "An error occurred: " . mysqli_error($connection);
		} else {
			// Commit transaction
			mysqli_commit($connection);
			echo "<script>alert('Quiz and all related records deleted successfully.')</script>";
		}
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
    <title>Quiz Information</title>

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/admin-adminSearchQuiz.css" />
</head>

<body>
    <div class="wrapper">
        <h1>Quiz Information</h1>
        <div class="search-bar">
            <form action="" method="post">
                <input type="text" name="quizId" placeholder="Quiz ID" />
                <input type="text" name="classId" placeholder="Class ID" />
                <select name="quizNameStartsWith" id="quiz">
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
                    <th class="quiz-id">Quiz ID</th>
                    <th class="quizname">Quiz Name</th>
                    <th class="classid">Class ID</th>
                    <th class="classname">Class Name</th>
                    <th class="teacher">Teacher Name</th>
                    <th class="date">Creation Date</th>
                    <th class="btn"></th>
                </tr>
                <?php foreach ($quizzes as $quiz): ?>
                <tr>
                    <td><?php echo htmlspecialchars($quiz['quizid']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['quizname']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['classid']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['classname']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['fname'] . ' ' . $quiz['lname']); ?></td>
                    <td><?php echo htmlspecialchars($quiz['creationdate']); ?></td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="quizIdToDelete"
                                value="<?php echo htmlspecialchars($quiz['quizid']); ?>" />
                            <input type="submit" name="btn-delete" value="Delete"
                                onclick="return confirm('Are you sure you want to delete this quiz?');" />
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>

</body>

</html>