<?php
include 'asmdbConnection.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Breeze Quiz - Registration</title>
    <link rel="shortcut icon" href="breezequiz.png" type="image/png">
    <style>
        body {
    display: flex;
    justify-content: flex-start;
    align-items: center;
    height: 100vh;
    margin: 0 150px;
    font-family: Arial, sans-serif;
}

.container {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    max-width: 400px;
    margin: 0;
    padding: 50px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

form {
    display: flex;
    flex-direction: column;
    width: 100%;
}

.input-group {
    margin-bottom: 20px;
}

label {
    display: block;