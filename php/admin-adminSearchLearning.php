<?php
include "connection.php";
include "session-check.php";

checkPageAccess(['admin']);
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
                <input type="text" name="search" placeholder="Quiz ID" />
                <input type="text" name="search" placeholder="Class ID" />
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
                <tr>
                    <td>LM ID</td>
                    <td>Learning Material Name</td>
                    <td>Class ID</td>
                    <td>Class Name</td>
                    <td>Teacher Name</td>
                    <td>Creation Date</td>
                    <td>
                        <input type="submit" name="btn-delete" value="Delete" />
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <!-- copyright part -->
    <?php include '../php/z-user-copyright.php'; ?>

</body>

</html>