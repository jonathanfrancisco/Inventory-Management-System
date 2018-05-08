

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

    <!--VIEW FULL INVOICE MODAL-->
    <?php
            if(isset($_GET["detailed"])){
                $id = $_GET["detailed"];
               

                $products = fetchData("SELECT * FROM invoice_product INNER JOIN product ON invoice_product.product_id = product.product_id WHERE invoice_product.invoice_id = '$id'");
                

                $itemsGridHTML = "";
                $itemsGridHTML = "<div style='border-bottom: 1px solid black' class='invoice-products__row'><strong>ProductName</strong><strong>Price</strong><strong>Qty</strong><strong>Total</strong></div>";
                while($row = mysqli_fetch_array($products)) {
                    $itemsGridHTML .= "<div style='border-bottom: 1px solid black' class='invoice-products__row'><p>".$row["product_name"]."</p> <p>₱".$row["product_price"]."</p> <p>".$row["quantity"]."</p> <p>₱".($row["product_price"]*$row["quantity"])."</p></div>";
                }

                $invoice = fetchData("SELECT * FROM invoice WHERE invoice_id = '$id'");
                $row = mysqli_fetch_assoc($invoice);  

                $itemsGridHTML .= "<div style='text-align: right' class='invoice-products__row'><p></p><p></p><p>Total Amount:</p><p style='text-align: center; font-weight: bold'>₱".$row["total_amount"]."</p></div>";
                $itemsGridHTML .= "<div style='text-align: right' class='invoice-products__row'><p></p><p></p><p>Amount Paid:</p><p style='text-align: center; font-weight: bold; border-bottom: 1px solid black'>₱".$row["amount_paid"]."</p></div>";
                $itemsGridHTML .= "<div style='text-align: right' class='invoice-products__row'><p></p><p></p><p>Change:</p><p style='text-align: center'>₱".($row["amount_paid"]-$row["total_amount"])."</p></div>";
               
              

                echo "<div class='modal-container modal-invoice show-modal'>".
                        "<form action='products.php' method='POST' class='modal-container__modal-form modal-edit__form show-modal__form'>".
                            "<h2>Invoice Details</h2>".
                            "<p><strong>Invoice #: </strong>".$row["invoice_id"]."</p>".
                            "<p><strong>Transaction Date: </strong>".date_format(date_create($row["invoice_date"]), 'g:ia \o\n l jS F Y')."</p>".
                            "<p><strong>Customer Name: </strong>".$row["customer_name"]."</p>".
                            "<p><strong>Customer Address: </strong>".$row["customer_address"]."</p>".
                            "<p><strong>Customer Contact: </strong>".$row["customer_contact"]."</p>".
                            "<h4>-----------------------------------------------------Items-----------------------------------------------------</h4>".
                            "<div class='invoice-products'>".
                            $itemsGridHTML.
                            "</div>".
                    
                            "<button type='button' class='modal-cancel-btn' onclick='toggleInvoiceModal()'>Close</button>".
                        "</form>".
                    "</div>";

            }
        ?>


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
                
                <?php 

                    if($view == "inventory")
                        echo "<h3>#</h3>
                        <h3>Action Taken</h3>
                        <h3>Quantity</h3>
                        <h3>Product</h3>
                        <h3>Date</h3>";
                    else if($view == "sales")
                        echo "<h3>#</h3>
                        <h3>Transaction Date</h3>
                        <h3>Sold To</h3>
                        <h3>Amount Paid</h3>
                        <h3>Action(s)</h3>";
                ?>
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

                    $itemsPerPage = 10;
                    if(!isset($_GET["page"]))
                        $currentPage = 1;
                    else 
                        $currentPage = $_GET["page"];   
                    $offset = $currentPage == 1 ? $offset = 0 : $offset = ($currentPage-1) * $itemsPerPage;
                    $totalPages = ceil((fetchData("SELECT * FROM invoice")->num_rows / $itemsPerPage));

                    $salesLog = fetchData("SELECT * FROM invoice ORDER BY invoice_id DESC LIMIT $itemsPerPage OFFSET $offset");
            
                    while($row = mysqli_fetch_array($salesLog)) {
                        echo "<div class='table__row inventory__row'>".
                                "<h4>".$row["invoice_id"]."</h4>".
                                "<h4>".date_format(date_create($row["invoice_date"]), 'g:ia \o\n l jS F Y')."</h4>".
                                "<h4>".$row["customer_name"]."</h4>".
                                "<h4>₱".$row["total_amount"]."</h4>".
                                "<a class='action-btn update' href='sales-inventory.php?view=".$view."&q=".@$_GET["q"]."&page=".$currentPage."&detailed=".$row["invoice_id"]."'>View Full Invoice</a>".
                            "</div>";
                    }

                }

                //sales-inventory.php?view=sales&q=&page=2&detailed=1



                        
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