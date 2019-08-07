<?php

namespace Gcd\Scaffold\Payments\Logic\Services;

use Gcd\Scaffold\Payments\Logic\Exceptions\PaymentServiceNotRecognisedException;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\DependencyInjection\Container;
use Rhubarb\Crown\Exceptions\ClassMappingException;

abstract class PaymentService
{
    public abstract function startPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function confirmPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function refundPayment(PaymentEntity $entity) : PaymentEntity;

    public abstract function settlePayment(PaymentEntity $entity) : PaymentEntity;

    /**
     * An opportunity for a payment service to repopulate properties that aren't stored
     * in the scaffold. For example Stripe do not allow you to store the public secret
     * for a payment intent, however we must restore this to the entity in order for
     * the follow on screen to be able to process the payment.
     *
     * @param PaymentEntity $entity
     * @return PaymentEntity
     */
    public abstract function rehydratePayment(PaymentEntity $entity): PaymentEntity;

    public abstract function restartPaymentOnSession(PaymentEntity $entity): PaymentEntity;

    private static $paymentServices = [];

    public abstract function getAlias(): string;

    /**
     * Registers a payment service being active in a project
     *
     * This allows for recognition of payment services from the entries in the models
     *
     * @param string $paymentServiceClassName
     */
    public static function registerPaymentService(string $paymentServiceClassName)
    {
        self::$paymentServices[] = $paymentServiceClassName;
    }

    /**
     * Get's a list of payment services indexed by their alias.
     *
     * @return array
     * @throws \Rhubarb\Crown\Exceptions\ClassMappingException
     */
    private static function getProviderAliases()
    {
        $aliases = [];

        foreach(self::$paymentServices as $providerClassName) {
            $service = Container::current()->getInstance($providerClassName);
            $aliases[$service->getAlias()] = $service;
        }

        return $aliases;
    }

    /**
     * Returns the correct service for a give alias.
     *
     * @param string $paymentServiceAlias
     * @return PaymentService
     * @throws PaymentServiceNotRecognisedException
     */
    public static function getPaymentServiceForAlias(string $paymentServiceAlias): PaymentService
    {
        try {
            $aliases = self::getProviderAliases();

            if (isset($aliases[$paymentServiceAlias])) {
                $service = $aliases[$paymentServiceAlias];
                return $service;
            }
        } catch(ClassMappingException $er){}

        throw new PaymentServiceNotRecognisedException($paymentServiceAlias);
    }
}