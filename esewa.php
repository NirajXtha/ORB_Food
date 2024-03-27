<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Esewa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
<style>
        body{
            background: url('images/esewa.png');
            background-color: #1f0f0f;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <?php 

        include("connection/connect.php");
        include_once 'product-action.php';
        error_reporting(0);
        session_start();

        if (empty($_SESSION["user_id"])) {
            header('location:login.php');
        }

        foreach ($_SESSION["cart_item"] as $item) {
            $pid =  $pid . $item['d_id'];
            $sk = $sk . $item['title'] . ' ';
            $item_total += ($item["price"] * $item["quantity"]);

        }
        $amount = intval($item_total);
        $transaction_uuid=bin2hex(random_bytes(20));
        $product_code="EPAYTEST";
        $secret_key='8gBm/:&EnhH.1/q';
        $message = 'total_amount='.$amount.',transaction_uuid='.$transaction_uuid.',product_code='.$product_code;
        // echo $message. "<br>";
        
        $signature = base64_encode(hash_hmac('sha256',$message, $secret_key, true));
        // echo ($signature);
        // var_dump($item_total);
        
    ?>
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST" id="esewa" hidden>
            <input type="text" id="amount" name="amount" value="<?php echo($amount); ?>" required>
            <input type="text" id="tax_amount" name="tax_amount" value="0" required>
            <input type="text" id="total_amount" name="total_amount" value="<?php echo($amount); ?>" required>
            <input type="text" id="transaction_uuid" name="transaction_uuid" value=<?php echo($transaction_uuid) ?> required>
            <input type="text" id="product_code" name="product_code" value="EPAYTEST" required>
            <input type="text" id="product_service_charge" name="product_service_charge" value="0" required>
            <input type="text" id="product_delivery_charge" name="product_delivery_charge" value="0" required>
            <input type="text" id="success_url" name="success_url" value="http://localhost/a/your_orders.php" required>
            <input type="text" id="failure_url" name="failure_url" value="http://localhost/a/index.php" required>
            <input type="text" id="signed_field_names" name="signed_field_names" value="total_amount,transaction_uuid,product_code" required>
            <input type="text" id="signature" name="signature" value=<?php echo($signature) ?>  required>
            <input value=" Submit" type="submit">
        </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


    <script>
        document.getElementById("esewa").submit();
    </script>
</body>
</html>