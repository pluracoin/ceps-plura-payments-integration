<?php

$address = "Pv7gU9dRVKFg8y1Y3YBLzQJm3owZwhfr8aTS3JaZsJBPa6sZzzDeSE8SHiKsta4MYQWpEg8ok27ufUmoaSKu9L5c2WAgwj5G9";
$amount = "1499";
$name = "Sample payment";
$payment_id = "f13adc8ac78eb22ffcee3f82e0e9ffb251dc7dc0600ef599087a89b623ca1402";

// -------------

$amount_atomic = $amount * 10000000000;
$name_encoded = rawurlencode($name);

$request = "pluracoin://".$address."?amount=".$amount_atomic."&name=".$name_encoded."&paymentid=".$payment_id;

echo $request."<br><br>";

echo "<a href=\"".$request."\">Pay ".$amount." PLURA</a>";
