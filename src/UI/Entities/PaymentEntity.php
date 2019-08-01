<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

class PaymentEntity
{
    const STATUS_CREATED = "Created";
    const STATUS_SUCCESS = "Success";
    const STATUS_FAILED = "Failed";
    const STATUS_AWAITING_SCA = "Failed";

    /**
     * @var string The unique identifier for this payment with the provider
     */
    public $providerIdentifier;

    /**
     * @var string Some providers give an identifier for use in SCA completion journies
     */
    public $providerPublicIdentifier;

    /**
     * @var string The status of the payment
     */
    public $status;

    public $amount;

    public $currency;

    public $description;

    public $billingAddress;
}