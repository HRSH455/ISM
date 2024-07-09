<?php
include 'link.php';
session_start();
if ($_POST['Action'] == "Cart") {
    $product = explode('-', $_POST["Product"])[0];
    $price = (int)explode('-', $_POST["Product"])[1];
    $cart_user = mysqli_query($link, "SELECT * FROM `cart` WHERE Username = '" . $_SESSION['Username'] . "'");
    if (mysqli_num_rows($cart_user) == 0) {
        $sql = mysqli_query($link, "INSERT INTO `cart` VALUES('','" . $_SESSION['Username'] . "','" . $_POST['Product'] . "')");
    } else {
        while ($row1 = mysqli_fetch_assoc($cart_user)) {
            $item_list = $row1['Items'];
            if ($item_list == NULL) {
                $item_list .= $_POST['Product'];
            } else {
                $item_list .= ',' . $_POST['Product'];
            }
        }
        $sql = mysqli_query($link, "UPDATE `cart` SET Items = '$item_list' WHERE Username = '" . $_SESSION['Username'] . "'");
    }
    if ($sql) {
        echo "success";
    } else {
        echo "failure";
    }
}

if ($_POST['Action'] == "Remove") {
    $prod = $_POST['Product'];
    $cart_user = mysqli_query($link, "SELECT * FROM `cart` WHERE Username = '" . $_SESSION['Username'] . "'");
    if (mysqli_num_rows($cart_user) == 0) {
        echo  "empty";
    } else {
        while ($row1 = mysqli_fetch_assoc($cart_user)) {
            $item_list = $row1['Items'];
            if ($item_list != NULL) {
                if (str_contains($item_list, "," . $prod)) {
                    $prod = ',' . $prod;
                    $item_list = preg_replace("/\b$prod\b/i", "", $item_list, 1);
                } else if (str_contains($item_list, $prod . ",")) {
                    $prod =  $prod . ',';
                    $item_list = preg_replace("/\b$prod\b/i", "", $item_list, 1);
                } else if (trim($item_list) == "") {
                    $item_list = NULL;
                } else {
                    $item_list = preg_replace("/\b$prod\b/i", "", $item_list, 1);
                }
            }
        }
        if ($item_list == NULL) {
            $sql = mysqli_query($link, "UPDATE `cart` SET Items = NULL WHERE Username = '" . $_SESSION['Username'] . "'");
        } else {
            $sql = mysqli_query($link, "UPDATE `cart` SET Items = '$item_list' WHERE Username = '" . $_SESSION['Username'] . "'");
        }
        if ($sql) {
            echo "success";
        } else {
            echo "failure";
        }
    }
}
