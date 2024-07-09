<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>Login Page</title>
</head>

<body class="bg-light">
    <div class="container justify-content-center">
        <form action="" method="post">
            <div class="row mt-5 justify-content-center">
                <div class="col-lg-2">
                    <label for="">Username:</label>
                </div>
                <div class="col-lg-4">
                    <input type="text" class="form-control" name="Username" id="username" required>
                </div>
            </div>
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-2">
                    <label for="">Password:</label>
                </div>
                <div class="col-lg-4">
                    <input type="password" class="form-control" name="Password" id="password" required>
                </div>
            </div>
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-1">
                    <button class="btn btn-primary" name="Login" type="submit">Login</button>
                </div>
            </div>
            <div class="row mt-4 justify-content-center">
                <div class="col-lg-2">
                    <a href="register.php">New User? Register here</a>
                </div>
            </div>
        </form>
    </div>

    <?php
    include 'link.php';
    if (isset($_POST['Login'])) {
        $username = $_POST['Username'];
        $password = $_POST['Password'];

        $query1 = mysqli_query($link, "SELECT * FROM `user` WHERE Username = '$username'");
        if (mysqli_num_rows($query1) == 0) {
            echo "<script>alert('User not found!')</script>";
        } else {
            while ($row1 = mysqli_fetch_assoc($query1)) {
                if ($row1['Password'] != $password) {
                    echo "<script>alert('Incorrect Password!')</script>";
                } else {
                    session_start();
                    $_SESSION["Username"] = $username;
                    $_SESSION["Full_Name"] = $row1['Full_Name'];
                    header("Location: user_dashboard.php");
                }
            }
        }
    }
    ?>
</body>

</html>