

<?php

require('functions.php');
session_start();

if(!isset($_SESSION["loggedIn"]))
    header("location:login.php");

if($_SERVER["REQUEST_METHOD"] == "POST") {
 

    $cName = $_POST["customerName"];
    $cContact = $_POST["customerContact"];
    $cAddress = $_POST["customerAddress"];
    $totAmount = $_POST["totalAmount"];
    $paidAmount = $_POST["paidAmount"];

    manageData("INSERT INTO invoice (invoice_date, customer_name, customer_contact, customer_address, total_amount, amount_paid) VALUES(NOW(),'$cName', '$cContact', '$cAddress','$totAmount','$paidAmount')");

    $lastInserted = fetchData("SELECT * FROM invoice ORDER BY invoice_id DESC LIMIT 1");
    $row = mysqli_fetch_assoc($lastInserted);  
    
    
    $invoiceID = $row["invoice_id"];

 
    



    for($i = 0; $i<count($_POST["product"]); $i++) {
        $id = $_POST["product"][$i];
        $quantity = $_POST["quantity"][$i];
       manageData("UPDATE product SET product_stock = product_stock-$quantity WHERE product_id = '$id'");
       manageData("INSERT INTO inventory (inventory_action, inventory_quantity, product_id, inventory_date) VALUES('STOCK-OUT','$quantity', $id, NOW())");
       manageData("INSERT INTO invoice_product (invoice_id, product_id, quantity) VALUES('$invoiceID','$id','$quantity')");
    }

  
   

 


    // manageData("UPDATE product SET product_stock = product_stock-$number WHERE product_id = '$id'");
    // manageData("INSERT INTO inventory (inventory_action, inventory_quantity, product_id, inventory_date) VALUES('STOCK-OUT','$number', $id, NOW())");


   
   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>Point of Sale</title>
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
        <h2>Point of Sale</h2>
    </div>


    <div class="container__body">

        <form method="POST" action="pos.php">
            <label>Customer name:</label>
            <input required name="customerName" type="text">
            <br>
            <label>Customer contact:</lable>
            <input required name="customerContact" type="text">
            <br>
            <label>Customer address:</lable>
            <input required name="customerAddress" type="text">
            <br>
            <label>Products:</label>
            <br>
            <div class="productsCart">
                <div class="cartRow">
                    <div>
                        <label>Select product:</label>
                        <br>
                        <select required name="product[]" class="first">
                            <option disabled selected value="">Select product:</option>
                            
                            <?php
                                $products = fetchData("SELECT * FROM product ORDER BY product_name");
                                
                                while($row = mysqli_fetch_array($products)) {
                                    
                                    echo "<option data-stocks='".$row["product_stock"]."' value='".$row["product_id"]."' data-price='".$row["product_price"]."'>".$row["product_name"]."</option>";
                                    

                                }
                                

                            ?>
                        </select>
                    </div>
                    <div>
                        <label>Price:</label>
                        <br>
                        <input class="price" type="text" readonly style="background-color: rgba(0,0,0,0.2)" value="">
                    </div>
                    <p>X</p>
                    <div>
                        <label>Quantity:</label>
                        <br>
                        <input required class="quantity" type="number" name="quantity[]" min="1">
                    </div>
                    <p>=</p>
                    <div>
                        <label>Total:</label>
                        <br>
                        <input class="total" type="number" readonly style="background-color: rgba(0,0,0,0.2)" value="">
                    </div>
                  
                </div>
            </div>
            <button class="addCartRow">+ Add Product Row</button>
            <br> 
            <label>Total Amount:</label>
            <input required id="totalAmount" name="totalAmount" style="background-color: rgba(0,0,0,0.2)" readonly type="number">
            <br>
            <label>Amount Paid:</lable>
            <input class="paidAmount" required name="paidAmount" type="number">
            <br>
            <label>Change:</label>
            <input class="changeAmount" style="background-color: rgba(0,0,0,0.2)" readonly type="number">
            <br>
            <input type="submit" value="Checkout">

        </form>


    </div>
    
 

</div>
<script src="assets/app.js"></script>
</body>
</html>