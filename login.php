<?php

    require('functions.php');
    session_start();

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $result = fetchData("SELECT * FROM user WHERE username = '$username' AND password = '$password'");
        if($result->num_rows == 1) {
            $_SESSION["loggedIn"] = true;
            header("location:home.php");
        }
        else
            $errorMessage = "Incorrect username or password";
    }

    else if(isset($_SESSION["loggedIn"]))
        header("location:home.php");

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login">

    <form class="login__form" method="POST" action="login.php">
        <?php

            if(isset($errorMessage))
                echo "<div class='errorMessage'><h3>Incorrect username or password</h3></div>"

        ?>
        <label for="username">Username:</label>
        <br>
        <input required id="username" type="text" name="username">
        <br>
        <label for="password">Password:</label>
        <br>
        <input required id="password" type="password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>

</body>
</html>