<?php

use App\PaymentGateway\Paddle\Transaction;
use Ramsey\Uuid\UuidFactory;

require __DIR__ . '/../vendor/autoload.php';

$id = new UuidFactory();

echo $id->uuid4();

$paddleTransaction = new Transaction();

var_dump($paddleTransaction);