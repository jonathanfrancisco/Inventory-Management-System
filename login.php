<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body class="login-body">

    <form class="login-body__form" method="POST" action="login.php">
        <label for="username">Username:</label>
        <br>
        <input required id="username" type="text" name="username">
        <br>
        <label for="password">Password:</label>
        <br>
        <input required id="username" type="password" name="password">
        <br>
        <input type="submit" value="Login">
    </form>

</body>
</html>