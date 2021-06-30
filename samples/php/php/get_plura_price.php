<?php

/* sample response
 {
   "pluracoin":{
      "usd":0.00068919,
      "sek":0.00586844,
      "rub":0.04970808,
      "nzd":0.00097876,
      "mxn":0.01367057,
      "jpy":0.076236,
      "inr":0.05118,
      "gbp":0.00049674,
      "eur":0.000578,
      "chf":0.00063386,
      "cny":0.0044495,
      "cad":0.00085065,
      "aud":0.00091096,
      "ltc":5.06e-06,
      "eth":3.26337e-07,
      "btc":2.0023e-08
   }
}
 */


$data = json_decode(file_get_contents("https://mw-api-eu.pluracoin.org/price"));
echo "USD: ".$data->pluracoin->usd;
