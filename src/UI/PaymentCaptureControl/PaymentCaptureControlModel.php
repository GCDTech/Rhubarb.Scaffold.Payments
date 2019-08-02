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

    /**
     * @var bool True if the customer is driving the UI and can respond to SCA
     */
    public $onSession = true;

    public function __construct()
    {
        $this->confirmPaymentEvent = new Event();
    }

    protected function getExposableModelProperties()
    {
        $list = parent::getExposableModelProperties();
        $list[] = "paymentEntity";
        $list[] = "onSession";

        return $list;
    }


}