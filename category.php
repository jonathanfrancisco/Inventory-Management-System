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

    <div class="header">
        <h1>Inventory Management System</h1>
        <h2 class="header__time"></h2>
        <a href="logout.php"><h2>Logout</h2></a>
    </div>

    <div class="container">
        <h2>Manage Categories</h2>
        <div class="table">
            <div class="table__header table__row category__row">
                <h3>#</h3>
                <h3>Category</h3>
                <h3>Actions</h3>
            </div>


            <div class="table__row category__row">
                <p>1</p>
                <p>Graphics Cards</p>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>
            </div>
            <div class="table__row category__row">
                <p>2</p>
                <p>Processors</p>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
            <div class="table__row category__row">
                <p>3</p>
                <p>Motherboards</p>
                <div>
                    <a class="action-btn update" href="">Update</a>
                    <a class="action-btn remove" href="">Remove</a>
                </div>  
            </div>
            <div class="table__row category__row">
                <p>4</p>
                <p>Storage Devices</p>
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