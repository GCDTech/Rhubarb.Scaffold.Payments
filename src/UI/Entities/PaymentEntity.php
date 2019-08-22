<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

use Gcd\Scaffold\Payments\Logic\Entities\CastableEntityTrait;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;

class PaymentEntity implements \JsonSerializable
{
    use CastableEntityTrait;

    const STATUS_CREATED = "Created";
    const STATUS_SUCCESS = "Success";
    const STATUS_FAILED = "Failed";
    const STATUS_AWAITING_AUTHENTICATION = "Awaiting Authentication";

    const TYPE_TOKEN = "token";
    const TYPE_CARD = "card";
    const TYPE_CUSTOMER = "customer";

    public $id;

    /**
     * @var string The unique identifier for this payment with the provider
     */
    public $providerIdentifier;

    /**
     * @var string A reference by alias to the service used to process this entity.
     */
    public $provider;

    /**
     * @var string The unique identifier for the payment method being used on this payment
     */
    public $providerPaymentMethodIdentifier;

    /**
     * @var string The type of identifier for this payment i.e. Token, Card, Customer
     */
    public $providerPaymentMethodType;

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
     * @var string A provider specific reference for the customer if required
     */
    public $providerCustomerId;

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

    public $cardExpiryMonth;

    public $cardExpiryYear;

    public $metaData;

    public $providerChargeIdentifier;

    public $isMOTO = false;

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

    public static function fromSetupEntity(SetupEntity $entity)
    {
        $paymentEntity = new PaymentEntity();
        $paymentEntity->providerCustomerId = $entity->providerCustomerId;
        $paymentEntity->providerPaymentMethodIdentifier = $entity->providerPaymentMethodIdentifier;

        return $paymentEntity;
    }
}