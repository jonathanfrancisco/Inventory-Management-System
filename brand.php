<?php



    require('functions.php');
    session_start();

    if(!isset($_SESSION["loggedIn"]))
        header("location:login.php");

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $brandName = $_POST["brandName"];
        if($_POST["type"] == "add") {
            manageData("INSERT INTO brand (brand_name) VALUES('$brandName')");
            $latestPage = ceil(fetchData("SELECT * FROM brand")->num_rows / 10);
            header("location:brand.php?q=&page=$latestPage");
        }
        
        else if($_POST["type"] == "update") {
            $id = $_POST["id"];
            manageData("UPDATE brand SET brand_name = '$brandName' WHERE brand_id = '$id'");
        }
    }

    else if(isset($_GET["delete"])) {
        $id = $_GET["delete"];
        manageData("DELETE FROM brand WHERE brand_id = '$id'");
    }



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

     <!--UPDATE MODAL-->
     <?php
        if(isset($_GET["update"])){
            $id = $_GET["update"];
            $brand = fetchData("SELECT * FROM brand WHERE brand_id = '$id'");
            $row = mysqli_fetch_assoc($brand);
            echo "<div class='modal-container modal-edit show-modal'>".
                    "<form action='brand.php' method='POST' class='modal-container__modal-form modal-edit__form show-modal__form'>".
                        "<label>Brand name:</label>".
                        "<br>".
                        "<input required type='text' name='brandName' value='".$row["brand_name"]."'>".
                        "<br>".
                        "<input type='hidden' name='id' value='".$row["brand_id"]."'>".
                        "<input type='hidden' name='type' value='update'>".
                        "<input class='submit' type='submit' value='Save'>".
                        "<button type='button' class='modal-cancel-btn' onclick='toggleEditModal()'>Cancel</button>".
                    "</form>".
                "</div>";

        }
    ?>

    <!--ADD MODAL-->
    <div class="modal-container modal-add">
        <form action="brand.php" method="POST" class="modal-container__modal-form modal-add__form">
            <label>Brand name:</label>
            <br>
            <input required type="text" name="brandName">
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
            <h1>Manage Brands</h1>
        </div>
        <div class="search__add__container">
            <form>
                <input class="search-box" type="search" name="q" placeholder="Search brand">
                <input class="search" type="submit" value="Search" class="search-btn">
            </form>
            <button class="add" onclick="toggleAddModal()">+ Add Brand</button>
        </div>

        <div class="table">
            <div class="table__header table__row brand__row">
                <h3>#</h3>
                <h3>Brand</h3>
                <h3>Actions</h3>
            </div>
           
            <?php
                $itemsPerPage = 10;
                if(!isset($_GET["page"]))
                    $currentPage = 1;
                else 
                    $currentPage = $_GET["page"];   
                $offset = $currentPage == 1 ? $offset = 0 : $offset = ($currentPage-1) * $itemsPerPage;
                $totalPages = ceil((fetchData("SELECT * FROM brand")->num_rows / $itemsPerPage));

                if(isset($_GET["q"]) && $_GET["q"] != "") {
                    $keywords = $_GET["q"];
                    if($keywords == "") {
                        $brands = fetchData("SELECT * FROM brand LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT * FROM brand")->num_rows / $itemsPerPage);
                    }
                    else {
                        $brands = fetchData("SELECT * FROM brand WHERE brand_name LIKE '%$keywords%' LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT * FROM brand WHERE brand_name LIKE '%$keywords%'")->num_rows / $itemsPerPage);
                    }
                }

                else 
                    $brands = fetchData("SELECT * FROM brand LIMIT $itemsPerPage OFFSET $offset");
                    
                while($row = mysqli_fetch_array($brands))
                    echo "<div class='table__row brand__row'>".
                            "<h4>".$row["brand_id"]."</h4>".
                            "<h4>".$row["brand_name"]."</h4>".
                            "<div>".
                                "<a class='action-btn update' href='brand.php?q=".@$_GET["q"]."&page=".$currentPage."&update=".$row["brand_id"]."'>Update</a>".
                                "<a class='action-btn remove' href='brand.php?q=".@$_GET["q"]."&page=".$currentPage."&delete=".$row["brand_id"]."'>Remove</a>".
                            "</div>".
                        "</div>";
                ?>
        </div>

        <div class="pagination">
            <?php
                if($currentPage > 1)
                    echo "<a href='brand.php?q=".@$_GET["q"]."&page=".($currentPage-1)."'>< Previous Page</a>";
                if($currentPage < $totalPages)
                    echo "<a href='brand.php?q=".@$_GET["q"]."&page=".($currentPage+1)."'>Next Page ></a>";
            ?>  
        </div>

    </div>
    <script src="assets/app.js"></script>
</body>
</html>