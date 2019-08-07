<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Gcd\UseCases\UseCase;

class TakePaymentUseCase extends UseCase
{
    /** @var PaymentService $paymentService */
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function execute(PaymentEntity $paymentEntity) {

        $canConfirm = true;

        if ($paymentEntity->status == PaymentEntity::STATUS_CREATED) {
            // We are only beginning the payment journey so we need to create our payment.
            $paymentEntity = $this->paymentService->startPayment($paymentEntity);

            $endStatuses = [
                PaymentEntity::STATUS_AWAITING_AUTHENTICATION,
                PaymentEntity::STATUS_SUCCESS,
                PaymentEntity::STATUS_FAILED
            ];

            if (in_array($paymentEntity->status, $endStatuses)){
                $canConfirm = false;
            }
        }

        // We will set the capture_method during confirm if auto-settle is false.
        if ($canConfirm && $paymentEntity->providerIdentifier) {
            $paymentEntity = $this->paymentService->confirmPayment($paymentEntity);
        }

        // Save our payment results
        $paymentTracking = PaymentTracking::fromEntity($paymentEntity);
        $paymentTracking->Provider = $this->paymentService->getAlias();
        $paymentTracking->save();

        return $paymentEntity;
    }

}