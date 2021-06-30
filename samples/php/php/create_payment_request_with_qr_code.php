<?php

// see create_payment_request.php on how to create payment request

$payment_request = "pluracoin://Pv7gU9dRVKFg8y1Y3YBLzQJm3owZwhfr8aTS3JaZsJBPa6sZzzDeSE8SHiKsta4MYQWpEg8ok27ufUmoaSKu9L5c2WAgwj5G9?amount=14990000000000&name=Sample%20payment&paymentid=f13adc8ac78eb22ffcee3f82e0e9ffb251dc7dc0600ef599087a89b623ca1402";

?>
<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>QR code payment request</title>

</head>

<body>

<div>
    <p>Scan this QR code with your PLURA mobile wallet</p>
</div>

<div id="qr_payment"></div>


<script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

<script type="text/javascript">
    new QRCode(document.getElementById("qr_payment"), "<? echo $payment_request; ?>");
</script>

</body>
</html>
