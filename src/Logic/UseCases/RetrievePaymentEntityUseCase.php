<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Gcd\UseCases\UseCase;

class RetrievePaymentEntityUseCase extends UseCase
{
    public function execute($paymentTrackingId):PaymentEntity
    {
        $trackingModel = new PaymentTracking($paymentTrackingId);
        $entity = $trackingModel->toEntity();

        $service = PaymentService::getPaymentServiceForAlias($entity->provider);
        $entity = $service->rehydratePayment($entity);

        return $entity;
    }
}