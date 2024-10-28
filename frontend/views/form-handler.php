<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    echo $email;
    if(empty($email) or empty($password)) {
        exit();
    }
    header("Location: ./inicio.php");
}else {
    header("Location: ./inicio.php");
}