<?php

    require('functions.php');
    session_start();

    if(!isset($_SESSION["loggedIn"]))
        header("location:login.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $categoryName = $_POST["categoryName"];
        if($_POST["type"] == "add") {
            manageData("INSERT INTO category (category_name) VALUES('$categoryName')");
            $latestPage = ceil(fetchData("SELECT * FROM category")->num_rows / 10);
            header("location:category.php?q=&page=$latestPage");
        }
        
        else if($_POST["type"] == "update") {
           $id = $_POST["id"];
           manageData("UPDATE category SET category_name = '$categoryName' WHERE category_id = '$id'");
        }
    }

    else if(isset($_GET["delete"])) {
        $id = $_GET["delete"];
        manageData("DELETE FROM category WHERE category_id = '$id'");
    }

   
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Categories</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!--UPDATE MODAL-->
    <?php
        if(isset($_GET["update"])){
            $id = $_GET["update"];
            $category = fetchData("SELECT * FROM category WHERE category_id = '$id'");
            $row = mysqli_fetch_assoc($category);
            echo "<div class='modal-container modal-edit show-modal'>".
                    "<form action='category.php' method='POST' class='modal-container__modal-form modal-edit__form show-modal__form'>".
                        "<label>Category name:</label>".
                        "<br>".
                        "<input required type='text' name='categoryName' value='".$row["category_name"]."'>".
                        "<br>".
                        "<input type='hidden' name='id' value='".$row["category_id"]."'>".
                        "<input type='hidden' name='type' value='update'>".
                        "<input class='submit' type='submit' value='Save'>".
                        "<button type='button' class='modal-cancel-btn' onclick='toggleEditModal()'>Cancel</button>".
                    "</form>".
                "</div>";

        }
    ?>

    <!--ADD MODAL-->
    <div class="modal-container modal-add">
        <form action="category.php" method="POST" class="modal-container__modal-form modal-add__form">
            <label>Category name:</label>
            <br>
            <input required type="text" name="categoryName">
            <br>
            <input type="hidden" name="type" value="add">
            <input class="submit" type="submit" value="Save">
            <button type="button" class="modal-cancel-btn" onclick="toggleAddModal()">Cancel</button>
        </form>
    </div>

    <div class="header">
        <h1>Inventory Management System</h1>
        <h2 class="header__time"></h2>
        <a href="logout.php"><h2>Logout</h2></a>
    </div>

    <div class="container">
        <div class="container__header">
            <a href="home.php"><h2>< Back</h2></a>
            <h1>Manage Categories</h1>
        </div>
        <div class="search__add__container">
            <form>
                <input class="search-box" type="search" name="q" placeholder="Search category">
                <input class="search" type="submit" value="Search" class="search-btn">
            </form>
            <button class="add add-modal" onclick="toggleAddModal()">+ Add Category</button>
        </div>
        <div class="table">
            <div class="table__header table__row category__row">
                <h3>#</h3>
                <h3>Category</h3>
                <h3>Actions</h3>
            </div>

            <?php
                $itemsPerPage = 10;
                if(!isset($_GET["page"]))
                    $currentPage = 1;
                else 
                    $currentPage = $_GET["page"];   
                $offset = $currentPage == 1 ? $offset = 0 : $offset = ($currentPage-1) * $itemsPerPage;
                $totalPages = ceil((fetchData("SELECT * FROM category")->num_rows / $itemsPerPage));

                if(isset($_GET["q"]) && $_GET["q"] != "") {
                    $keywords = $_GET["q"];
                    if($keywords == "") {
                        $categories = fetchData("SELECT * FROM category LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT * FROM category")->num_rows / $itemsPerPage);
                    }
                    else {
                        $categories = fetchData("SELECT * FROM category WHERE category_name LIKE '%$keywords%' LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT * FROM category WHERE category_name LIKE '%$keywords%'")->num_rows / $itemsPerPage);
                    }
                }

                else 
                    $categories = fetchData("SELECT * FROM category LIMIT $itemsPerPage OFFSET $offset");
        
                while($row = mysqli_fetch_array($categories))
                    echo "<div class='table__row category__row'>".
                            "<h4>".$row["category_id"]."</h4>".
                            "<h4>".$row["category_name"]."</h4>".
                            "<div>".
                                "<a class='action-btn update' href='category.php?q=".@$_GET["q"]."&page=".$currentPage."&update=".$row["category_id"]."'>Update</a>".
                                "<a class='action-btn remove' href='category.php?q=".@$_GET["q"]."&page=".$currentPage."&delete=".$row["category_id"]."'>Remove</a>".
                            "</div>".
                        "</div>";
            ?>

        </div>
        <div class="pagination">
            <?php
                if($currentPage > 1)
                    echo "<a href='category.php?q=".@$_GET["q"]."&page=".($currentPage-1)."'>< Previous Page</a>";
                if($currentPage < $totalPages)
                    echo "<a href='category.php?q=".@$_GET["q"]."&page=".($currentPage+1)."'>Next Page ></a>";
            ?>  
        </div>

    </div>
    <script src="assets/app.js"></script>
</body>
</html>