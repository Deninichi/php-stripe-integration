<?php
require_once('stripe/init.php');

$stripe = array(
  "secret_key"      => "sk_test_p1HQHWNGS4MTGEcXI5EIARwY",
  "publishable_key" => "pk_test_zyBMr9UGh1IaX89X2dACkdV4"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>