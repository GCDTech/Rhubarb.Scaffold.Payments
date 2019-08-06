<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\SimulatorPaymentService;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\Tests\Fixtures\TestCases\RhubarbTestCase;
use Rhubarb\Stem\Filters\Equals;

class ConfirmPaymentUseCaseTest extends RhubarbTestCase
{
    public function test_payment_no_auth_needed()
    {
        $entity = new PaymentEntity();
        $entity->providerIdentifier = '123';
        $entity->providerPublicIdentifier = SimulatorPaymentService::SUCCESS_CARD;
        $entity->fullName = 'John Smith';
        $entity->emailAddress = 'jsmith@gcdtech.com';
        $entity->amount = 1000;
        $entity->currency = 'GBP';

        $entity = ConfirmPaymentUseCase::create(new SimulatorPaymentService())->execute($entity);

        // TODO use card ID here
        $paymentTracking = PaymentTracking::findLast(new Equals('ProviderPublicIdentifier', $entity->providerPublicIdentifier));
        verify($paymentTracking->CardLastFourDigits)->notEmpty();
        verify($paymentTracking->Status)->equals(PaymentTracking::STATUS_SUCCESS);
    }

    public function test_payment_auth_needed()
    {
        $entity = new PaymentEntity();
        $entity->providerIdentifier = '123';
        $entity->providerPublicIdentifier = SimulatorPaymentService::SUCCESS_CARD; // TODO use card field
        $entity->fullName = 'John Smith';
        $entity->emailAddress = 'jsmith@gcdtech.com';
        $entity->amount = 100;
        $entity->currency = 'GBP';

        $entity = ConfirmPaymentUseCase::create(new SimulatorPaymentService())->execute($entity);

        // TODO use card ID here
        $paymentTracking = PaymentTracking::findLast(new Equals('ProviderPublicIdentifier', $entity->providerPublicIdentifier));
        verify($paymentTracking->CardLastFourDigits)->notEmpty();
        verify($paymentTracking->ProviderPublicIdentifier)->notEmpty();
        verify($paymentTracking->Status)->equals(PaymentTracking::STATUS_AWAITING_SCA);

        $entity->providerPublicIdentifier = SimulatorPaymentService::SUCCESS_CARD; // TODO use card field

        $entity = ConfirmPaymentUseCase::create(new SimulatorPaymentService())->execute($entity);

        $paymentTracking = PaymentTracking::findLast(new Equals('ProviderPublicIdentifier', $entity->providerPublicIdentifier));
        verify($paymentTracking->CardLastFourDigits)->notEmpty();
        verify($paymentTracking->ProviderPublicIdentifier)->notEmpty();
        verify($paymentTracking->Status)->equals(PaymentTracking::STATUS_SUCCESS);
    }

    public function test_payment_failed()
    {
        $entity = new PaymentEntity();
        $entity->providerIdentifier = '123';
        $entity->providerPublicIdentifier = SimulatorPaymentService::FAIL_CARD;
        $entity->fullName = 'John Smith';
        $entity->emailAddress = 'jsmith@gcdtech.com';
        $entity->amount = 1000;
        $entity->currency = 'GBP';

        $entity = ConfirmPaymentUseCase::create(new SimulatorPaymentService())->execute($entity);

        // TODO use card ID here
        $paymentTracking = PaymentTracking::findLast(new Equals('ProviderPublicIdentifier', $entity->providerPublicIdentifier));
        verify($paymentTracking->CardLastFourDigits)->notEmpty();
        verify($paymentTracking->Status)->equals(PaymentTracking::STATUS_FAILED);
        verify($paymentTracking->FailedMessage)->notEmpty();
    }

    // Create verify data function to compare fields
}
