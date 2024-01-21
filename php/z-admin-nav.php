<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigational Bar</title>
</head>

<link rel="stylesheet" href="../css/nav.css" />
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

<body>
    <div class="navbar">
        <a href="../php/admin-adminDashboard.php">
            <img src="../picture/logo.png" class="logo" />
        </a>
        <ul>
            <li><a href="../php/admin-aboutUs.php">About Us</a></li>

            <li class="no-a">Other Pages<i class="bx bxs-chevron-down"></i>
                <div class="sub-menu">
                    <ul>
                        <li><a href="../php/user-eduRegulation.php" target="_blank">Educational Regulation</a></li>
                        <li><a href="../php/user-dataPrivacy.php" target="_blank">Data Privacy Law</a></li>
                    </ul>
                </div>
            </li>

            <li class="no-a">Admin<i class="bx bxs-chevron-down"></i>

                <div class="sub-menu">
                    <ul>
                        <li><a href="../php/logout.php">Log Out</a></li>
                    </ul>
                </div>

            </li>
        </ul>
    </div>
</body>

</html>