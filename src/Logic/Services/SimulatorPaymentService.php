<?php

namespace Gcd\Scaffold\Payments\Logic\Services;


use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;

class SimulatorPaymentService extends PaymentService
{
    const SUCCESS_CARD = 'card_success';
    const FAIL_CARD = 'card_fail';
    const AWAITING_SCA_CARD = 'card_sca';

    public function startPayment(PaymentEntity $entity): PaymentEntity
    {
       $entity->cardExpiry = '02/22';
       $entity->cardLastFourDigits = '4444';
       $entity->cardType = 'visa';
       $entity->providerPublicIdentifier = uniqid();
       $entity->providerIdentifier = uniqid();

       return $entity;
    }

    public function confirmPayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        if (!$entity->status == PaymentEntity::STATUS_AWAITING_AUTHENTICATION) {
            array_push($statusArray, PaymentEntity::STATUS_AWAITING_AUTHENTICATION);
        }

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function refundPayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_AWAITING_AUTHENTICATION, PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function settlePayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_AWAITING_AUTHENTICATION, PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function syncPayment(PaymentEntity $entity): PaymentEntity
    {
        return $entity;
    }

    public function getAlias(): string
    {
        return "Simulator";
    }

    /**
     * An opportunity for a payment service to repopulate properties that aren't stored
     * in the scaffold. For example Stripe do not allow you to store the public secret
     * for a payment intent, however we must restore this to the entity in order for
     * the follow on screen to be able to process the payment.
     *
     * @param PaymentEntity $entity
     * @return PaymentEntity
     */
    public function rehydratePayment(PaymentEntity $entity): PaymentEntity
    {
        $entity->providerPublicIdentifier = "public_secret";

        return $entity;
    }
}