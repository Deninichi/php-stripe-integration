<?php
  require_once('./config.php');

  $token  = $_POST['stripeToken'];
  $name = $_POST['name'];
  $email = $_POST['email'];
  $card_num = $_POST['card_num'];
  $card_cvc = $_POST['cvc'];
  $card_exp_month = $_POST['exp_month'];
  $card_exp_year = $_POST['exp_year'];

  $customer = \Stripe\Customer::create(array(
      'email' => $email,
      'source'  => $token
  ));

  $itemName = "Quote request";
  $itemNumber = "PS123456";
  $itemPrice = 12.99;
  $currency = "usd";
  $orderID = "SKA92712382139";

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $itemPrice*100,
      'currency' => $currency,
      'description' => $itemName,
      'metadata' => array(
        'order_id' => $orderID
      )
    )
  );

  echo "<h1>Successfully charged $itemPrice!</h1>";