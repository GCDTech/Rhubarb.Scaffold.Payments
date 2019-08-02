<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

use Gcd\Scaffold\Payments\Logic\Entities\CastableEntityTrait;

class PaymentEntity
{
    use CastableEntityTrait;

    const STATUS_CREATED = "Created";
    const STATUS_SUCCESS = "Success";
    const STATUS_FAILED = "Failed";
    const STATUS_AWAITING_AUTHENTICATION = "Awaiting Authentication";

    const TYPE_TOKEN = "Token";
    const TYPE_CARD = "Card";
    const TYPE_CUSTOMER = "Customer";

    /**
     * @var string The unique identifier for this payment with the provider
     */
    public $providerIdentifier;

    /**
     * @var string The unique identifier for the payment method being used on this payment
     */
    public $providerPaymentMethodIdentifier;

    /**
     * @var string The type of identifier for this payment i.e. Token, Card, Customer
     */
    public $providerPublicIdentifierType = self::TYPE_TOKEN;

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

    /**
     * @var bool True if the customer is driving the UI and can respond to SCA challenges.
     */
    public $onSession = true;

    public $amount;

    public $currency;

    public $description;

    public $fullName;

    public $addressLine1;

    public $addressLine2;

    public $addressCity;

    public $addressPostCode;

    public $phone;

    public $emailAddress;

    public $cardType;

    public $cardLastFourDigits;

    public $cardExpiry;
}