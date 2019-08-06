<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Rhubarb\Crown\Tests\Fixtures\TestCases\RhubarbTestCase;

class RetrievePaymentEntityUseCaseTest extends RhubarbTestCase
{
    private function getUseCase(): RetrievePaymentEntityUseCase
    {
        return RetrievePaymentEntityUseCase::create();
    }

    public function testRetrieveCreatesEntity()
    {
        $paymentTracking = new PaymentTracking();
        $paymentTracking->ProviderIdentifier = "abc123";
        $paymentTracking->save();

        $useCase = $this->getUseCase();
        $entity = $useCase->execute($paymentTracking->PaymentTrackingID);

        verify($entity->providerIdentifier)->equals("abc123");
    }
}
