

<?php

    require('functions.php');
    session_start();

    if(!isset($_SESSION["loggedIn"]))
        header("location:login.php");

    if(!isset($_GET["view"]))
        $view = "inventory";
    else if($_GET["view"] == "inventory")
        $view = "inventory";
    else if($_GET["view"] == "sales")
        $view = "sales";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales & Inventory</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
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
            <h2>Sales & Inventory Log</h2>
        </div>

        
        <div class="tab-form">
            <a class="<?php if($view == "inventory") echo "tab-selected"; else {} ?>" href="sales-inventory.php?view=inventory">Inventory Log</a>
            <a class="<?php if($view == "sales") echo "tab-selected"; else {} ?>" href="sales-inventory.php?view=sales">Sales Log</a>
        </div>
        <div class="table">
            <div class="table__header table__row inventory__row">
                <h3>#</h3>
                <h3>Action Taken</h3>
                <h3>Quantity</h3>
                <h3>Product</h3>
                <h3>Date</h3>
            </div>

                <?php

                if($view == "inventory") {

                    $itemsPerPage = 10;
                    if(!isset($_GET["page"]))
                        $currentPage = 1;
                    else 
                        $currentPage = $_GET["page"];   
                    $offset = $currentPage == 1 ? $offset = 0 : $offset = ($currentPage-1) * $itemsPerPage;
                    $totalPages = ceil((fetchData("SELECT * FROM inventory")->num_rows / $itemsPerPage));

                    // if(isset($_GET["q"]) && $_GET["q"] != "") {
                    //     $keywords = $_GET["q"];
                    //     if($keywords == "") {
                    //         $categories = fetchData("SELECT * FROM category LIMIT $itemsPerPage OFFSET $offset");
                    //         $totalPages = (fetchData("SELECT * FROM category")->num_rows / $itemsPerPage);
                    //     }
                    //     else {
                    //         $categories = fetchData("SELECT * FROM category WHERE category_name LIKE '%$keywords%' LIMIT $itemsPerPage OFFSET $offset");
                    //         $totalPages = (fetchData("SELECT * FROM category WHERE category_name LIKE '%$keywords%'")->num_rows / $itemsPerPage);
                    //     }
                    // }

                    // else 
                    $iventoriesLog = fetchData("SELECT * FROM inventory INNER JOIN product ON inventory.product_id = product.product_id ORDER BY inventory_id DESC LIMIT $itemsPerPage OFFSET $offset");
            
                    while($row = mysqli_fetch_array($iventoriesLog)) {
                        
                        $row["inventory_action"] == "STOCK-IN" ? $color = "green" : $color = "red";

                        echo "<div class='table__row inventory__row'>".
                                "<h4>".$row["inventory_id"]."</h4>".
                                "<h4 style='color:".$color."'>".$row["inventory_action"]."</h4>".
                                "<h4>".$row["inventory_quantity"]."</h4>".
                                "<h4>".$row["product_name"]."</h4>".
                                "<h4>".date_format(date_create($row["inventory_date"]), 'g:ia \o\n l jS F Y')."</h4>".
                            "</div>";

                    }

                }   

                else if($view == "sales") {

                    

                }



                        
                ?>

        </div>
            
        <div class="pagination">
            <?php
                if($currentPage > 1)
                    echo "<a href='sales-inventory.php?view=".$view."&q=".@$_GET["q"]."&page=".($currentPage-1)."'>< Previous Page</a>";
                if($currentPage < $totalPages)
                    echo "<a href='sales-inventory.php?view=".$view."&q=".@$_GET["q"]."&page=".($currentPage+1)."'>Next Page ></a>";
            ?>  
        </div>

    </div>
    <script src="assets/app.js"></script>
</body>
</html>