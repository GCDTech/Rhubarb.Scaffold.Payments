<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Gcd\UseCases\UseCase;

class RestartPaymentOnSessionUseCase extends UseCase
{
    public function execute(PaymentEntity $entity)
    {
        $service = PaymentService::getPaymentServiceForAlias($entity->provider);
        $entity = $service->restartPaymentOnSession($entity);

        return $entity;
    }
}