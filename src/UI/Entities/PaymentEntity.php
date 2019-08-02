<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

use Gcd\Scaffold\Payments\Logic\Entities\CastableEntityTrait;

class PaymentEntity implements \JsonSerializable
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

    /**
     * The last error during processing.
     *
     * @var string
     */
    public $error;


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        // Because the PaymentEntity is passed right down the chain sometimes payment
        // services attach properties on this object to reduce network round trips
        // between methods called in series. However those objects might be private and
        // so we have to be sure that we don't pass those to the client.
        $officialKeys = array_keys(get_object_vars(new PaymentEntity()));
        $data = get_object_vars($this);
        $dataKeys = array_keys($data);

        foreach($dataKeys as $key){
            if (!in_array($key, $officialKeys)){
                unset($data[$key]);
            }
        }

        return $data;
    }
}