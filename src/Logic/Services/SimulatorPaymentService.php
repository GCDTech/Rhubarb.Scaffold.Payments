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
       $entity->providerPublicIdentifier = 'pi_12345';
       $entity->providerIdentifier = 'card_12345';
    }

    public function confirmPayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        if (!$entity->status == PaymentEntity::STATUS_AWAITING_SCA) {
            array_push($statusArray, PaymentEntity::STATUS_AWAITING_SCA);
        }

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function refundPayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_AWAITING_SCA, PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function settlePayment(PaymentEntity $entity): PaymentEntity
    {
        $statusArray = [PaymentEntity::STATUS_AWAITING_SCA, PaymentEntity::STATUS_FAILED, PaymentEntity::STATUS_SUCCESS];

        $entity->status = $statusArray[array_rand($statusArray)];
        return $entity;
    }

    public function syncPayment(PaymentEntity $entity): PaymentEntity
    {
        return $entity;
    }
}