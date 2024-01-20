<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['teacher']);

if (isset($_POST['btn-submit'])) {
    $lmname = mysqli_real_escape_string($connection, $_POST['quizName']);
    $classCode = mysqli_real_escape_string($connection, $_POST['classCode']);
    $content = mysqli_real_escape_string($connection, $_POST['textarea']);
    $video = isset($_POST['video']) ? mysqli_real_escape_string($connection, $_POST['video']) : '';

    // Check if the class exists
    $getClassIdQuery = "SELECT classid FROM tblclass WHERE classid = '$classCode'";
    $resultClassId = mysqli_query($connection, $getClassIdQuery);

    if ($resultClassId && mysqli_num_rows($resultClassId) > 0) {
        $classData = mysqli_fetch_assoc($resultClassId);
        $classid = $classData['classid'];
        $teacherid = $_SESSION['teacherid'];
        $creationdate = date("Y-m-d H:i:s");

        // Insert into tbllm
        $insertLMQuery = "INSERT INTO tbllm (teacherid, classid, lmname, creationdate, text, video) VALUES ('$teacherid', '$classid', '$lmname', '$creationdate', '$content', '$video')";
        
        if (mysqli_query($connection, $insertLMQuery)) {
            echo '<script>alert("Learning material created successfully!");</script>';
        } else {
            echo '<script>alert("Error inserting learning material: ' . mysqli_error($connection) . '")</script>';
        }
    } else {
        echo '<script>alert("Class code not found.");</script>';
    }
    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Learning Material</title>

    <link rel="stylesheet" href="../css/teacher-createLearning.css" />
    <link rel="stylesheet" href="../css/nav.css" />
    <link rel="stylesheet" href="../css/footer.css" />

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />

    <script src="../javascript/wordLimit.js"></script>
</head>

<body>
    <!-- content -->
    <div class="main-wrapper">
        <h1>Create Learning Material</h1>
        <div class="input-area">
            <form action="" method="post">
                <label for="quizName">Learning Material Name</label>
                <input type="text" name="quizName" id="quizName" placeholder="Enter Learning Material Name" required />
                <label for="classCode">Class Code</label>
                <input type="text" name="classCode" id="classCode" placeholder="Enter Class Code" required />
                <div class="content">
                    <div class="text">
                        <label for="textarea">Content</label>
                        <textarea name="textarea" id="textarea" cols="30" rows="10" placeholder="Enter Content Here"
                            required></textarea>
                    </div>
                    <div class="video">
                        <label for="video"> Youtube Video Link</label>
                        <input type="text" name="video" id="video" placeholder="Enter Youtube Video Link" />
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" class="btn-submit" name="btn-submit">Create Learning Module</button>
                </div>
            </form>
        </div>
    </div>
    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>