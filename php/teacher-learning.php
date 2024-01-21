<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['teacher']);

// get learning material id
if (isset($_GET['lmid'])) {
    $learningMaterialId = $_GET['lmid'] ?? null; ; 
}

// Step 2: create the sql commands
$query = "SELECT lm.lmname, c.classname, lm.creationdate, lm.text, lm.video
		FROM tbllm lm
		INNER JOIN tblclass c ON lm.classid = c.classid
		WHERE lm.lmid = $learningMaterialId";

// Step 3: Execute the query
$result = mysqli_query($connection, $query);

// Step 4: Read the results
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lmName = $row['lmname'];
    $className = $row['classname'];
    $creationDate = $row['creationdate'];
    $text = $row['text'];
    $video = $row['video'];
}

// Step 5: Close the connection
mysqli_close($connection);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Learning Material</title>

    <link rel="stylesheet" href="../css/student-learning.css" />
</head>

<body>
    <div class="learning-content">

        <?php if (isset($lmName)): ?>

        <div class="lm-header">
            <h1><?php echo htmlspecialchars($lmName); ?></h1>
            <h2>Class: <?php echo htmlspecialchars($className); ?></h2>
            <h3>Creation date: <?php echo htmlspecialchars($creationDate); ?></h3>
        </div>

        <div class="lm-desc">
            <p><?php echo htmlspecialchars($text); ?></p>
        </div>

        <?php if (!empty($video)): ?>
        <div class="video">
            <iframe width="1200" height="600" src="<?php echo $video; ?>" title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
            </iframe>
        </div>
        <?php endif; ?>

        <?php else: ?>
        <p>No learning materials found.</p>
        <?php endif; ?>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>