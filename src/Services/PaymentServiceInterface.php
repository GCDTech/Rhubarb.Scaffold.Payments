<?php

namespace Gcd\Scaffold\Payments\Services;

interface PaymentServiceInterface
{
    public function startPayment($APIKey, PaymentServiceEntity $entity);

    public function confirmPayment($APIKey, PaymentServiceEntity $entity);

    public function refundPayment($APIKey, PaymentServiceEntity $entity);

    public function settlePayment($APIKey, PaymentServiceEntity $entity);
}