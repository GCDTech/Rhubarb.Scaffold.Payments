<?php

use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\Logic\Services\SimulatorPaymentService;

include_once __DIR__.'/../../../../../vendor/rhubarbphp/rhubarb/platform/execute-test.php';

PaymentService::registerPaymentService(SimulatorPaymentService::class);