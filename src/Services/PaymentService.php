<?php

namespace Gcd\Scaffold\Payments\Services;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;

abstract class PaymentService
{
    public abstract function startPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function confirmPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function refundPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function settlePayment(PaymentEntity $entity) : PaymentEntity;
}