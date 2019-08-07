<?php

namespace Gcd\Scaffold\Payments\Logic\Exceptions;

class PaymentServiceNotRecognisedException extends PaymentServiceException
{
    public function __construct($name)
    {
        parent::__construct("The payment service `".$name."` was not recognised.");
    }
}