<?php

namespace Gcd\Scaffold\Payments\Services;

interface PaymentServiceInterface
{
    public function startPayment();

    public function confirmPayment();

    public function refundPayment();

    public function settlePayment();
}