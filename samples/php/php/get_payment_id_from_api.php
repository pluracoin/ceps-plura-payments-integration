<?php

// get Payment ID from public API

$payment_id = file_get_contents("http://ceps.pluracoin.org:8080/paymentid");
echo $payment_id;
