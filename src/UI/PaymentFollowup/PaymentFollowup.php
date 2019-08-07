<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\Logic\Services\PaymentService;
use Gcd\Scaffold\Payments\Logic\UseCases\RestartPaymentOnSessionUseCase;
use Gcd\Scaffold\Payments\Logic\UseCases\RetrievePaymentEntityUseCase;
use Gcd\Scaffold\Payments\Logic\UseCases\TakePaymentUseCase;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Leaf\Leaves\Leaf;

class PaymentFollowup extends Leaf
{
    /** @var PaymentFollowupModel $model **/
    protected $model;

    public function __construct(?PaymentTracking $paymentTracking = null)
    {
        parent::__construct("", function() use ($paymentTracking){
            if ($paymentTracking) {
                $this->model->paymentEntity = RetrievePaymentEntityUseCase::create()->execute($paymentTracking->PaymentTrackingID);
            }
        });
    }

    protected function onModelCreated()
    {
        parent::onModelCreated();

        $this->model->startCustomerAuthenticationEvent->attachHandler(function($entity){
           $entity = PaymentEntity::castFromObject($entity);

           return RestartPaymentOnSessionUseCase::create()->execute($entity);
        });

        $this->model->paymentAuthenticatedEvent->attachHandler(function($entity){
            $entity = PaymentEntity::castFromObject($entity);
            $service = PaymentService::getPaymentServiceForAlias($entity->provider);

            return TakePaymentUseCase::create($service)->execute($entity);
        });
    }

    protected function getViewClass()
    {
        return PaymentFollowupView::class;
    }

    protected function createModel()
    {
        return new PaymentFollowupModel();
    }
}
