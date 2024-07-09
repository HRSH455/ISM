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
    <title>Password Page</title>
</head>

<body class="bg-light">
    <div class="container justify-content-center mt-5">
        <form action="" method="post">
            <div class="row mt-3 justify-content-center">
                <div class="col-lg-2">
                    <label for="">New Password:</label>
                </div>
                <div class="col-lg-4">
                    <input type="password" class="form-control" name="Password" id="password" required>
                </div>
            </div>
            <div class="row mt-2 justify-content-center">
                <div class="col-lg-3">
                    <button class="btn btn-primary" name="Change" type="submit">Change Password</button>
                </div>
            </div>
        </form>
        <div class="row mt-2 justify-content-center">
            <div class="col-lg-3">
                <a href="user_dashboard.php">Back to Shopping</a>
            </div>
        </div>
    </div>

    <?php
    include 'link.php';
    if (isset($_POST['Change'])) {
        $password = $_POST['Password'];

        $query1 = mysqli_query($link, "UPDATE `user` SET Password = '$password' WHERE Username = '" . $_SESSION['Username'] . "'");
        if ($query1) {
            echo "<script>alert('Password Updated Successfully!')</script>";
        } else {
            echo "<script>alert('Password Updation Failed!')</script>";
        }
    }
    ?>
</body>

</html>