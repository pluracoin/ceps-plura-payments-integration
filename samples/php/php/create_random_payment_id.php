<?php

//requires PHP 7+

$payment_id = bin2hex(random_bytes(32));
echo $payment_id;