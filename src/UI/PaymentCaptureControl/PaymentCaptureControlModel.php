<?php

namespace Gcd\Scaffold\Payments\UI\PaymentCaptureControl;

use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class PaymentCaptureControlModel extends LeafModel
{
    /**
     * @var Event Called when the UI is ready to confirm a payment. Accepts a PaymentEntity as an argument.
     */
    public $confirmPaymentEvent;

    public $paymentEntity;

    public function __construct()
    {
        $this->confirmPaymentEvent = new Event();
    }

    protected function getExposableModelProperties()
    {
        $list = parent::getExposableModelProperties();
        $list[] = "paymentEntity";

        return $list;
    }


}