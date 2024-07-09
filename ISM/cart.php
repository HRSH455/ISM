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
    <title>Cart Page</title>
</head>
<style>
</style>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-8">
                <h2 class="">Welcome <?php echo $_SESSION['Full_Name']; ?></h2> <br>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-3 "><a href="user_dashboard.php" class="btn btn-success">Shop</a></div>
                    <div class="col-lg-4 "><a href="logout.php" class="btn btn-danger">Log Out</a></div>
                </div>
            </div>
        </div>
        <h2 class="text-center ">Your Cart Items</h2>
        <table class="table table-striped text-center ">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="cartItems">
                <?php
                include "link.php";
                $sql = "SELECT * FROM cart WHERE Username='$_SESSION[Username]'";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $items = $row['Items'];
                        $products = explode(',', $row['Items']);
                    }
                    if (count($products) > 0 && $items != NULL) {
                        $total_price = 0;
                        foreach ($products as $product) {
                            $product_name = explode('-', $product)[0];
                            $product_price = explode('-', $product)[1];
                            $total_price += (int)$product_price;
                            echo '<tr>';
                            echo "<td>" . $product_name . "</td>";
                            echo "<td>" . $product_price . "</td>";
                            echo "
                            <td>
                                <button class='btn btn-danger' onclick='remove(this)'>Remove</button>
                            </td>";
                            echo '<tr>';
                        }
                        echo '
                        <tr>
                            <td colspan="3"><b>Grand Total: &#8377 ' . $total_price . '</b></td>
                        </tr>
                        ';
                    } else {
                        echo '
                        <tr>
                            <td colspan="3"><h4>No items in your cart.</h4
                        </tr>';
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="3"><h4>No items in your cart.</h4
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Scripts -->

    <!-- Remove Item from cart -->
    <script type="text/javascript">
        function remove(element) {
            var product = $(element).parent().siblings().eq(0).text() + '-' + $(element).parent().siblings().eq(1).text();
            $.ajax({
                url: 'modify_cart.php',
                type: 'post',
                data: {
                    Action: "Remove",
                    Product: product
                },
                success: function(data) {
                    console.log(data)
                    if (data == "empty") {
                        alert("Sorry, your Username not found in cart!")
                    } else {
                        location.reload();
                    }
                }
            })
        }
    </script>
</body>

</html>