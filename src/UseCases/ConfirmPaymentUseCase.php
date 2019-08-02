<?php

namespace Gcd\Scaffold\Payments\UseCases;

use Gcd\Scaffold\Payments\Services\PaymentService;
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

        if (!isset($paymentEntity->providerIdentifier)) {
            // We are only beginning the payment journey so we need to create our payment.
            $paymentEntity = $this->paymentService->startPayment($paymentEntity);
        }

        $paymentEntity = $this->paymentService->confirmPayment($paymentEntity);

        return $paymentEntity;
    }

}