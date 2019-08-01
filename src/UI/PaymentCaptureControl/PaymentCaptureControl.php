<?php

namespace Gcd\Scaffold\Payments\UI\PaymentCaptureControl;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\Leaves\LeafModel;

class PaymentCaptureControl extends Leaf
{
    /**
     * @var PaymentCaptureControlModel
     */
    protected $model;

    /**
     * Returns the name of the standard view used for this leaf.
     *
     * @return string
     */
    protected function getViewClass()
    {
        return PaymentCaptureControlView::class;
    }

    /**
     * Should return a class that derives from LeafModel
     *
     * @return LeafModel
     */
    protected function createModel()
    {
        return new PaymentCaptureControlModel();
    }

    protected function onModelCreated()
    {
        parent::onModelCreated();

        $this->model->confirmPaymentEvent->attachHandler(function(PaymentEntity $paymentEntity){
            
        });
    }
}