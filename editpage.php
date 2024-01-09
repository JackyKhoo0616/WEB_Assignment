<?php
include 'Connection.php';
$id = $_GET['ID'];

if (isset($_POST['btnUpdate'])){
    $fname = $_POST['txtFname'];
    $lname = $_POST['txtLname'];
    $email = $_POST['txtEmail'];
    $country = $_POST['txtCountry'];

    $query = "UPDATE `breezequiz` SET `First Name`='$fname', `Last Name`='$lname', `Email`='$email', `Country`='$country' WHERE `ID` = '$id'";

    if(mysqli_query($connection, $query)){
        echo 'Record Updated Successfully';
    } else {
        die('Record Updated Failed' . mysqli_error($connection));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>User Profile</h2>
    <?php
    $query = "SELECT * FROM breezequiz WHERE ID = '$id'";

    $results = mysqli_query($connection, $query);

    if(mysqli_num_rows($results) == 1){
        $row = mysqli_fetch_assoc($results);
    ?>
    <form action="editpage.php" method="post">
        ID : <?php echo $row['ID']; ?><br>
        First Name: <input type="text" name='txtFname' value="<?php echo $row['fname']; ?>"><br>
        Last Name: <input type="text" name='txtLname' value="<?php echo $row['lname']; ?>"><br>
        Email Address: <input type="text" name='txtEmail' value="<?php echo $row['email']; ?>"><br>
        Country: <input type="text" name='txtCountry' value="<?php echo $row['country']; ?>"><br>
        <input type="submit" value="Update Profile" name='btnUpdate'>
    </form>
<?php
}
?>
</body>
</html>

<?php
    mysqli_close($connection);
?>