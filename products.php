<?php
   require('functions.php');
   session_start();

   if(!isset($_SESSION["loggedIn"]))
       header("location:login.php");

   if($_SERVER["REQUEST_METHOD"] == "POST") {
        $productBarcode = @$_POST["productBarcode"];
        $productName = @$_POST["productName"];
        $productCategory = (int)@$_POST["productCategory"];
        $productBrand = (int)@$_POST["productBrand"];

       if($_POST["type"] == "add") {    
           $productStocks = (int)$_POST["productStocks"];
           manageData("INSERT INTO product (product_barcode, product_name, product_stock, category_id, brand_id) VALUES('$productBarcode','$productName','$productStocks','$productCategory','$productBrand')");
           $newProduct = fetchData("SELECT * F");
           $row = mysqli_fetch_assoc($newProduct);    
           $latestPage = ceil(fetchData("SELECT product.product_id, product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id;")->num_rows / 10);
           manageData("INSERT INTO inventory (inventory_action, inventory_quantity, product_id, inventory_date) VALUES('NEW PRODUCT STOCK-IN','$productSTocks', $id, NOW())");
           header("location:products.php?q=&page=$latestPage");
       }
       
       else if($_POST["type"] == "update") {
          $id = $_POST["id"];
          manageData("UPDATE product SET product_barcode = '$productBarcode', product_name = '$productName', category_id = '$productCategory', brand_id = '$productBrand' WHERE product_id = '$id'");
       }

       else if($_POST["type"] == "stockin") {
           $number = $_POST["numOfStocks"];
           $id = $_POST["id"];
           manageData("UPDATE product SET product_stock = product_stock+$number WHERE product_id = '$id'");
           manageData("INSERT INTO inventory (inventory_action, inventory_quantity, product_id, inventory_date) VALUES('STOCK-IN','$number', $id, NOW())");
           // add inventory log stock in
       }
       else if($_POST["type"] == "stockout") {
           $number = $_POST["numOfStocks"];
           $id = $_POST["id"];
           manageData("UPDATE product SET product_stock = product_stock-$number WHERE product_id = '$id'");
           manageData("INSERT INTO inventory (inventory_action, inventory_quantity, product_id, inventory_date) VALUES('STOCK-OUT','$number', $id, NOW())");
       }


   }

   else if(isset($_GET["delete"])) {
       $id = $_GET["delete"];
       manageData("DELETE FROM product WHERE product_id = '$id'");
   }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

    <?php
         if(isset($_GET["stockin"]) || isset($_GET["stockout"])){

           if(isset($_GET["stockin"])) {
               $id = $_GET["stockin"];
               $type = "stockin";
           }
           else {
                $id = $_GET["stockout"];
                $type = "stockout";
           }

           $product = fetchData("SELECT product.product_id, product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id WHERE product.product_id = '$id'");
           $row = mysqli_fetch_assoc($product);    

            echo "<div class='modal-container modal-stock show-modal'>".
                    "<form action='products.php' method='POST' class='modal-container__modal-form show-modal__form'>".
                        "<label>".($type == "stockin" ? "Stocks to add:" : "Stocks to remove:")."</label>".
                        "<br>".
                        "<input type='number' min='1'".($type == "stockin" ? "" : "max='".$row["product_stock"]."'")."required name='numOfStocks'>".
                        "<br>".
                        "<input type='hidden' name='id' value='".$row["product_id"]."'>".
                        "<input type='hidden' name='type' value='".$type."'>".
                        "<input class='submit' type='submit' value='Save'>".
                        "<button type='button' class='modal-cancel-btn' onclick='toggleStockModal()'>Cancel</button>".
                    "</form>".
                "</div>";

        }
    ?>

    <!--UPDATE MODAL-->
    <?php
            if(isset($_GET["update"])){
                $id = $_GET["update"];
                $product = fetchData("SELECT product.product_id, product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id WHERE product.product_id = '$id'");
                $row = mysqli_fetch_assoc($product);    


                $categoriesHTML = "<select required name='productCategory'>";
                $categories = fetchData("SELECT * FROM category ORDER BY category_name ASC");
                while($catrow = mysqli_fetch_array($categories)) 
                    if($row["category_id"] == $catrow["category_id"])
                        $categoriesHTML .= "<option selected value='".$catrow["category_id"]."'>".$catrow["category_name"]."</option>";
                    else
                        $categoriesHTML .= "<option value='".$catrow["category_id"]."'>".$catrow["category_name"]."</option>";
                $categoriesHTML .= "</select>";


                $brandsHTML = "<select required name='productBrand'>";
                $brands = fetchData("SELECT * FROM brand ORDER BY brand_name ASC");
                while($brandrow = mysqli_fetch_array($brands)) 
                    if($row["brand_id"] == $brandrow["brand_id"])
                        $brandsHTML .= "<option selected value='".$brandrow["brand_id"]."'>".$brandrow["brand_name"]."</option>";
                    else
                        $brandsHTML .= "<option value='".$brandrow["brand_id"]."'>".$brandrow["brand_name"]."</option>";
                $brandsHTML .= "</select>";



               
                echo "<div class='modal-container modal-edit show-modal'>".
                        "<form action='products.php' method='POST' class='modal-container__modal-form modal-edit__form show-modal__form'>".
                            "<label>Barcode:</label>".
                            "<br>".
                            "<input required type='text' name='productBarcode' value='".$row["product_barcode"]."'>".
                            "<br>".
                            "<label>Name:</label>".
                            "<br>".
                            "<input required type='text' name='productName' value='".$row["product_name"]."'>".
                            "<br>".
                            "<label>Category:</label>".
                            "<br>".
                            $categoriesHTML.
                            "<br>".
                            "<label>Brand:</label>".
                            "<br>".
                            $brandsHTML.
                            "<br>".
                            "<input type='hidden' name='id' value='".$row["product_id"]."'>".
                            "<input type='hidden' name='type' value='update'>".
                            "<input class='submit' type='submit' value='Save'>".
                            "<button type='button' class='modal-cancel-btn' onclick='toggleEditModal()'>Cancel</button>".
                        "</form>".
                    "</div>";

            }
        ?>

        <!--ADD MODAL-->
        <div class="modal-container modal-add">
            <form action="products.php" method="POST" class="modal-container__modal-form modal-add__form">
                <label>Product Barcode:</label>
                <br>
                <input required type="text" name="productBarcode">
                <br>
                <label>Product Name:</label>
                <br>
                <input required type="text" name="productName">
                <br>
                <label>Product Stock(s):</label>
                <br>
                <input required min="1" type="number" name="productStocks">
                <br>
                <label>Product Category:</label>
                <br>
                <select required name="productCategory">
                    <option disabled selected value="">Select category:</option>
                    <?php
                        $categories = fetchData("SELECT * FROM category ORDER BY category_name ASC");
                        while($row = mysqli_fetch_array($categories))
                            echo "<option value='".$row["category_id"]."'>".$row["category_name"]."</option>";
                    ?>
                </select>
                <br>
                <label>Product Brand:</label>
                <br>
                <select required name="productBrand">
                    <option disabled selected value="">Select brand:</option>
                    <?php
                        $brands = fetchData("SELECT * FROM brand ORDER BY brand_name ASC");
                        while($row = mysqli_fetch_array($brands))
                            echo "<option value='".$row["brand_id"]."'>".$row["brand_name"]."</option>";
                    ?>
                </select>
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
            <h2>Manage Products</h2>
        </div>
        <div class="search__add__container">
            <form>
                <input class="search-box" type="search" name="q" placeholder="Search category">
                <input class="search" type="submit" value="Search" class="search-btn">
            </form>
            <button class="add" onclick="toggleAddModal()">+ Add Product</button>
        </div>
    
        <div class="table">
            <div class="table__header table__row product__row">
                <h3>#</h3>
                <h3>Barcode</h3>
                <h3>Name</h3>
                <h3>Available Stock(s)</h3>
                <h3>Category</h3>
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
                $totalPages = ceil((fetchData("SELECT product.product_id,product.product_barcode,product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id")->num_rows / $itemsPerPage));

                if(isset($_GET["q"]) && $_GET["q"] != "") {
                    $keywords = $_GET["q"];
                    if($keywords == "") {
                        $products = fetchData("SELECT product.product_id,product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT product.product_id,product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id")->num_rows / $itemsPerPage);
                    }
                    else {
                        $products = fetchData("SELECT product.product_id,product.product_barcode,product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id WHERE CONCAT(product.product_barcode, product.product_name, category.category_name, brand.brand_name) LIKE '%$keywords%' LIMIT $itemsPerPage OFFSET $offset");
                        $totalPages = (fetchData("SELECT product.product_id,product.product_barcode,product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id WHERE CONCAT(product.product_barcode, product.product_name, category.category_name, brand.brand_name) LIKE '%$keywords%'")->num_rows / $itemsPerPage);
                    }
                }

                else 
                    $products = fetchData("SELECT product.product_id, product.product_barcode, product.product_name, product.product_stock, category.category_id, category.category_name, brand.brand_id, brand.brand_name FROM product INNER JOIN category ON product.category_id = category.category_id INNER JOIN brand ON product.brand_id = brand.brand_id LIMIT $itemsPerPage OFFSET $offset");
              
                while($row = mysqli_fetch_array($products))
                    echo "<div class='table__row product__row'>".
                            "<h4>".$row["product_id"]."</h4>".
                            "<h4>".$row["product_barcode"]."</h4>".
                            "<h4>".$row["product_name"]."</h4>".
                            "<h4>".$row["product_stock"]."</h4>".
                            "<h4>".$row["category_name"]."</h4>".
                            "<h4>".$row["brand_name"]."</h4>".
                            "<div class='actions'>".
                                "<a class='action-btn update' href='products.php?q=".@$_GET["q"]."&page=".$currentPage."&stockin=".$row["product_id"]."'>+Add Stocks</a>".
                                "<a class='action-btn update' href='products.php?q=".@$_GET["q"]."&page=".$currentPage."&update=".$row["product_id"]."'>Update</a>".
                                "<a class='action-btn remove' href='products.php?q=".@$_GET["q"]."&page=".$currentPage."&stockout=".$row["product_id"]."'>-Remove Stocks</a>".
                                "<a class='action-btn remove' href='products.php?q=".@$_GET["q"]."&page=".$currentPage."&delete=".$row["product_id"]."'>Remove</a>".
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