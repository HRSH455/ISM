<?php
session_start();
if (!isset($_SESSION['Username'])) {
    echo "<script>alert('Session Expired!Please Login Again!');location.href = 'index.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>User Dashboard</title>
</head>
<style>
    img {
        aspect-ratio:  1 / 1 !important;
        margin: 0 auto;
    }
</style>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-6">
                <h2 class="">Welcome <?php echo $_SESSION['Full_Name']; ?></h2> <br>
            </div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-2 "><a href="cart.php" class="btn btn-success">Cart</a></div>
                    <div class="col-lg-4 "><a href="password.php" class="btn btn-warning">Change Password</a></div>
                    <div class="col-lg-4 "><a href="logout.php" class="btn btn-danger">Log Out</a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <h2 class="">Categories:</h2> <br>
            </div>
            <div class="col-lg-4">
                <div class="">
                    <form action="" method="get">
                        <select class="form-control" onchange="this.form.submit();" name="Category" id="category">
                            <option value="" selected disabled>-- Select Category --</option>
                            <option value="food">Food</option>
                            <option value="shoes">Shoes</option>
                            <option value="shirts">Shirts</option>
                            <option value="watches">Watches</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>
        <div class="container">
            <?php
            include 'link.php';
            $query1 = mysqli_query($link, "SELECT * FROM `items`");
            $items = [];
            if (isset($_GET['Category'])) {
                $category = $_GET['Category'];
                echo "<script>document.getElementById('category').value = '" . $category . "';</script>";
                $query1 = mysqli_query($link, "SELECT * FROM `items` WHERE Category = '$category'");
                if (mysqli_num_rows($query1) == 0) {
                    echo "<p style='color:red'>No items in this category.</p>";
                }
            }
            while ($row1 = mysqli_fetch_assoc($query1)) {
                $items[$row1['Item_Name']] = [$row1['Item_Name'], $row1['Item_Price'], $row1['Item_Path']];
            }
            $items = array_chunk($items, 3);
            foreach ($items as $row) {
                echo  '<div class="row g-4 mt-4">';
                foreach ($row as $item => $props) {
                    echo '
                    <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="' . $props[2] . '" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">' . $props[0] . '</h5>
                            <p class="card-text">Price:&#8377 ' . $props[1] . '</p>
                            <button class="btn btn-primary add" id="' . $props[0] . '-' . $props[1] . '">Add to Cart</button>
                        </div>
                    </div>
                </div>
                    ';
                }
                echo '</div>';
            }
            ?>
            <!-- <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/shirt.png" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Shirt</h5>
                            <p class="card-text">Price:&#8377 600</p>
                            <button class="btn btn-primary add" id="shirt-600">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/shoes.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Shoes</h5>
                            <p class="card-text">Price:&#8377 1800</p>
                            <button class="btn btn-primary add" id="shoes-1800">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/watch.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Watch</h5>
                            <p class="card-text">Price:&#8377 2500</p>
                            <button class="btn btn-primary add" id="watch-2500">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mt-5">
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/iphone.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">iphone 15 pro max Mobile</h5>
                            <p class="card-text">Price:&#8377 99,999</p>
                            <button class="btn btn-primary add" id="iphone-99999">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/laptop.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Laptop</h5>
                            <p class="card-text">Price:&#8377 43000</p>
                            <button class="btn btn-primary add" id="laptop-43000">Add to Cart</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card" style="width: 18rem;">
                        <img src="Images/keyboard.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">Keyboard</h5>
                            <p class="card-text">Price:&#8377 1049</p>
                            <button class="btn btn-primary add" id="keybaord-1049">Add to Cart</button>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>

    <!-- Scripts -->

    <!-- Add Item to cart -->
    <script type="text/javascript">
        $('.add').on('click', (e) => {
            let product = e.target.id;
            $.ajax({
                type: 'post',
                url: 'modify_cart.php',
                data: {
                    'Action': 'Cart',
                    "Product": product,
                },
                success: function(data) {
                    if (data == "success") {
                        alert('Item added to Cart!');
                        location.href = 'cart.php';
                    } else {
                        alert('Error adding item to cart, please try again later!');
                    }
                }
            })
        });
    </script>
</body>

</html>