<?php
include 'Connection.php';
$query = "SELECT * FROM breezequiz";

$result = mysqli_query($connection, $query);
?>
<table width=100% border=1>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Country</th>
    </tr>
<?php
while ($row = mysqli_fetch_assoc($result)){
?>
    <tr>
        <td><?php echo $row["ID"]; ?> </td>
        <td><?php echo $row["First Name"]; ?> </td>
        <td><?php echo $row["Last Name"]; ?> </td>
        <td><?php echo $row["Email"]; ?> </td>
        <td><?php echo $row["Country"]; ?> </td>
        <td><a href="editpage.php?id=<?php echo $row['ID']; ?>">Edit</a></td>
        <td><a href="deletePage.php?id=<?php echo $row['ID']; ?>">Delete</a></td>
    </tr>
<?php
}
mysqli_close($connection);
?>
</table>