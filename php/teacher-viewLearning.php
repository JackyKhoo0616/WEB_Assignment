<?php
include "connection.php"; 
include 'session-check.php'; 

if (isset($_POST['deleteLearningMaterial'])) {
    $learningMaterialIdToDelete = $_POST['learningMaterialId']; 

    // Delete the learning material
    $deleteLearningMaterialQuery = "DELETE FROM tbllm WHERE lmid = '$learningMaterialIdToDelete'";
    mysqli_query($connection, $deleteLearningMaterialQuery);

    // display message 
    echo "<script>alert('Learning material has been deleted.'); window.location.href = 'teacher-viewLearning.php';</script>";
    exit();
}
// Query to fetch learning materials
$query = "SELECT lmid, lmname FROM tbllm WHERE teacherid = '{$_SESSION['teacherid']}'";
$result = mysqli_query($connection, $query);

$learningMaterials = []; // store learning materials
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $learningMaterials[] = $row; // Add each row to the learningMaterials array
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learning Materials</title>

    <link rel="stylesheet" href="../css/teacher-viewLearning.css" />

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-teacher-nav.php"; ?>

    <!-- learning material -->
    <div class="learningpage-wrapper">
        <div class="header">
            <h1>Learning Material</h1>
            <div class="add-on-btn">
                <a href="../php/teacher-createLearning.php" target="_blank">
                    <button type="submit">Create Learning Material</button>
                </a>
            </div>
        </div>
        <div class="learningpage-container">

            <?php foreach ($learningMaterials as $learningMaterial): ?>
            <div class="learning">
                <div class="learning-info">
                    <h3><?= htmlspecialchars($learningMaterial['lmname']) ?></h3>
                </div>
                <div class="view-button">
                    <a href="../php/teacher-learning.php?lmid=<?= $learningMaterial['lmid'] ?>"
                        target="_blank"><button>View</button></a>
                    <form method="post">
                        <input type="hidden" name="learningMaterialId" value="<?= $learningMaterial['lmid'] ?>">
                        <input type="submit" name="deleteLearningMaterial" value="Delete"
                            onclick="return confirm('Are you sure you want to delete this learning material?');">
                    </form>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>