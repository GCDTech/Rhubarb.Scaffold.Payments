<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\SimulatorPaymentService;
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
        $paymentTracking->Amount = "123";
        $paymentTracking->Provider = "Simulator";
        $paymentTracking->save();

        $useCase = $this->getUseCase();
        $entity = $useCase->execute($paymentTracking->PaymentTrackingID);

        verify($entity->providerIdentifier)->equals("abc123");
        verify($entity->amount)->equals("123");
        verify($entity->provider)->equals("Simulator");
    }

    public function testEntityRehydratedByService()
    {
        $paymentTracking = new PaymentTracking();
        $paymentTracking->ProviderIdentifier = "abc123";
        $paymentTracking->Amount = "123";
        $paymentTracking->Provider = "Simulator";
        $paymentTracking->save();

        $useCase = $this->getUseCase();
        $entity = $useCase->execute($paymentTracking->PaymentTrackingID);

        verify($entity->providerPublicIdentifier)->equals("public_secret");
    }
}
