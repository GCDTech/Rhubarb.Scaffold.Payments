<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

use Gcd\Scaffold\Payments\Logic\Entities\CastableEntityTrait;

class PaymentEntity
{
    use CastableEntityTrait;

    const STATUS_CREATED = "Created";
    const STATUS_SUCCESS = "Success";
    const STATUS_FAILED = "Failed";
    const STATUS_AWAITING_SCA = "Awaiting SCA";

    /**
     * @var string The unique identifier for this payment with the provider
     */
    public $providerIdentifier;

    /**
     * @var string The type of identifier for this payment i.e. Card, Customer
     */
    public $providerPublicIdentifierType;

    /**
     * @var string Some providers give an identifier for use in SCA completion journeys
     */
    public $providerPublicIdentifier;

    /**
     * @var string The status of the payment
     */
    public $status = self::STATUS_CREATED;

    /**
     * @var bool True if you want the payment to auto settle or remain only authorised.
     */
    public $autoSettle = true;

    public $amount;

    public $currency;

    public $description;

    public $billingAddress;

    public $emailAddress;

    public $cardType;

    public $cardLastFourDigits;

    public $cardExpiry;
}