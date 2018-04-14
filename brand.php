<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {

    }

    else if(!isset($_SESSION["loggedIn"]))
        header("location:login.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brand</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <div class="header">
        <h1>Inventory Management System</h1>
        <h2 class="header__time"></h2>
        <a href="logout.php"><h2>Logout</h2></a>
    </div>

    <div class="container">
        <div class="container__header">
            <a href="home.php"><h2>< Back</h2></a>
            <h1>Manage Brands</h1>
        </div>
        <div class="search__add__container">
            <form>
                <input class="search-box" type="search" name="q" placeholder="Search category">
                <input class="search" type="submit" value="Search" class="search-btn">
            </form>
            <button class="add">+ Add Brand</button>
        </div>

        <div class="table">
            <div class="table__header table__row brand__row">
                <h3>#</h3>
                <h3>Brand</h3>
                <h3>Actions</h3>
            </div>
            <div class="table__row brand__row">
                <h4>1</h4>
                <h4>Asus</h4>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
            <div class="table__row brand__row">
                <h4>2</h4>
                <h4>Lenovo</h4>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
            <div class="table__row brand__row">
                <h4>3</h4>
                <h4>Nvidia</h4>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
            <div class="table__row brand__row">
                <h4>4</h4>
                <h4>Intel</h4>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
        </div>
    </div>

    <script src="assets/app.js"></script>
    
</body>
</html>