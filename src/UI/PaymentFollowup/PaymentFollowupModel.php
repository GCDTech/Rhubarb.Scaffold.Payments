<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\LeafModel;

class PaymentFollowupModel extends LeafModel
{
    /**
     * @var PaymentEntity
     */
    public $paymentEntity;

    /**
     * @var Event Raised when the customer hits the button to start the authentication process.
     */
    public $startCustomerAuthenticationEvent;

    /**
     * @var Event Raised when the customer successfully authenticates the payment.
     */
    public $paymentAuthenticatedEvent;

    public function __construct()
    {
        parent::__construct();

        $this->startCustomerAuthenticationEvent = new Event();
        $this->paymentAuthenticatedEvent = new Event();
    }

    protected function getExposableModelProperties()
    {
        $list = parent::getExposableModelProperties();
        $list[] = "paymentEntity";

        return $list;
    }
}