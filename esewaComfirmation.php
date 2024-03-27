<?php
    include("connection/connect.php");
    include_once 'product-action.php';
    error_reporting(0);
    session_start();
    $data = $_GET['data'];
    foreach ($_SESSION["cart_item"] as $item) {

        $item_total += ($item["price"] * $item["quantity"]);
    $SQL = "insert into users_orders(u_id,title,quantity,price,data) values('" . $_SESSION["user_id"] . "','" . $item["title"] . "','" . $item["quantity"] . "','" . $item["price"] . "','".$data."')";

    if(mysqli_query($db, $SQL)){
        unset($_SESSION["cart_item"]);
        unset($item["title"]);
        unset($item["quantity"]);
        unset($item["price"]);
        $success = "Thank you. Your order has been placed!";
        echo "<script>window.location.replace('your_orders.php');</script>";

    }else{
        echo "<script>alert('Something went wrong!! Try again!');</script>";
        echo "<script>window.location.replace('checkout.php');</script>";
    }
}
?>