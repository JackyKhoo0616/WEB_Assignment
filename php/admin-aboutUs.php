<?php
include "connection.php";
include 'session-check.php';

checkPageAccess(['admin']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About US</title>

    <link href="https://fonts.googleapis.com/css2?family=Lemon&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="../css/student-aboutUs.css" />
</head>

<body>
    <!-- navigational bar -->
    <?php include "z-admin-nav.php"; ?>

    <!-- content -->
    <div class="wrapper">
        <h1>About Us</h1>
        <div class="container">
            <div class="card">
                <div class="image">
                    <img src="../picture/ligeng.jpg" alt="image" />
                </div>
                <div class="title">
                    <h2>Yow Li Geng</h2>
                    <p>Website Developer</p>
                </div>
                <div class="text">
                    <p><i class='bx bx-user'></i>tp069263</p>
                    <p>
                        <i class='bx bx-envelope'></i>rexyow0624@gmail.com
                    </p>
                </div>
                <div class="button-container">
                    <a href="https://www.instagram.com/yows_mona_6189/" target="_blank">
                        <button type="submit">
                            <i class="bx bxl-instagram"></i> View More
                        </button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="../picture/munlok.jpg" alt="image" />
                </div>
                <div class="title">
                    <h2>Chew Mun Lok</h2>
                    <p>Website Developer</p>
                </div>
                <div class="text">
                    <p><i class='bx bx-user'></i>tp068835</p>
                    <p><i class='bx bx-envelope'></i>chewlok2003@gmail.com</p>
                </div>
                <div class="button-container">
                    <a href="https://www.instagram.com/munlok_/" target="_blank">
                        <button type="submit">
                            <i class="bx bxl-instagram"></i> View More
                        </button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="../picture/chunkeat.jpg" alt="image" />
                </div>
                <div class="title">
                    <h2>Lim Chun Keat</h2>
                    <p>Website Developer</p>
                </div>
                <div class="text">
                    <p><i class='bx bx-user'></i>tp068689</p>
                    <p>
                        <i class='bx bx-envelope'></i>wilsonchunkeat28@gmail.com
                    </p>
                </div>
                <div class="button-container">
                    <a href="https://www.instagram.com/3_cks/" target="_blank">
                        <button type="submit">
                            <i class="bx bxl-instagram"></i> View More
                        </button>
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="image">
                    <img src="../picture/jacky.jpg" alt="image" />
                </div>
                <div class="title">
                    <h2>Khoo Jiun Kang</h2>
                    <p>Website Developer</p>
                </div>
                <div class="text">
                    <p><i class='bx bx-user'></i>tp067542</p>
                    <p>
                        <i class='bx bx-envelope'></i></i>jackykhoo0616@gmail.com
                    </p>
                </div>
                <div class="button-container">
                    <a href="https://www.instagram.com/jacky__khoo/" target="_blank">
                        <button type="submit">
                            <i class="bx bxl-instagram"></i> View More
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- map -->

    <div class="map-container">
        <img src="../picture/location.png" alt="Office Location" />
        <div class="office-text">
            <h2>Our Office</h2>
            <p>
                <i class="bx bx-map"></i>123, Jalan ABC, 12345, Kuala Lumpur
            </p>
            <p><i class="bx bx-phone"></i>+603-699 5088</p>

            <div class="button-container">
                <a href="https://maps.app.goo.gl/riRGCzqYKhc6BCQV8" target="_blank">
                    <button type="submit">
                        <i class="bx bx-map-alt"></i> View Location
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include '../php/z-user-footer.php'; ?>
    <?php include '../php/z-user-copyright.php'; ?>
</body>

</html>