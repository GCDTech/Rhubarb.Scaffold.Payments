<?php

namespace Gcd\Scaffold\Payments\UI\Entities;

use Gcd\Scaffold\Payments\Logic\Entities\CastableEntityTrait;

class SetupEntity implements \JsonSerializable
{
    const STATUS_CREATED = 'Created';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAILED = 'Failed';

    use CastableEntityTrait;

    /**
     * @var string The unique identifier for this setup intent with the provider
     */
    public $providerIdentifier;

    public $provider;

    /**
     * @var string The unique identifier for the payment method being used on this payment
     */
    public $providerPaymentMethodIdentifier;

    /**
     * @var string Some providers give an identifier for use in SCA completion journeys
     */
    public $providerPublicIdentifier;

    /**
     * @var string A provider specific reference for the customer if required
     */
    public $providerCustomerId;

    /**
     * @var string The status of the payment
     */
    public $status = self::STATUS_CREATED;

    public $cardType;

    public $cardLastFourDigits;

    public $cardExpiryMonth;

    public $cardExpiryYear;

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