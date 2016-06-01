<?php

// Stripe singleton

require_once('init.php');
\Stripe\Stripe::setApiKey('sk_test_JQCcDe4RIqIq1IcmVfvLPyay ');
$myCard = array('number' => '4242424242424242', 'exp_month' => 8, 'exp_year' => 2018);
$charge = \Stripe\Charge::create(array('card' => $myCard, 'amount' => 10000, 'currency' => 'usd'));
echo '<pre>';
print_r($charge);