<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Gcd\UseCases\UseCase;

class ConfirmPaymentUseCase extends UseCase
{
    /** @var PaymentService $paymentService */
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function execute(PaymentEntity $paymentEntity) {

        if ($paymentEntity->status == PaymentEntity::STATUS_CREATED) {
            // We are only beginning the payment journey so we need to create our payment.
            $paymentEntity = $this->paymentService->startPayment($paymentEntity);
        }

        // We will set the capture_method during confirm if auto-settle is false.
        if ($paymentEntity->providerIdentifier) {
            $paymentEntity = $this->paymentService->confirmPayment($paymentEntity);
        }

        // Save our payment results
        $paymentTracking = PaymentTracking::fromEntity($paymentEntity);
        $paymentTracking->save();

        return $paymentEntity;
    }

}