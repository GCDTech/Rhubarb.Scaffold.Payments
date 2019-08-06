<?php

namespace Gcd\Scaffold\Payments\UI\PaymentCaptureControl;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Gcd\Scaffold\Payments\Logic\UseCases\ConfirmPaymentUseCase;
use Rhubarb\Crown\Events\Event;
use Rhubarb\Leaf\Leaves\Leaf;
use Rhubarb\Leaf\Leaves\LeafModel;

abstract class PaymentCaptureControl extends Leaf
{
    /**
     * @var PaymentCaptureControlModel
     */
    protected $model;

    /**
     * @var Event Raised when a payment confirmation succeeds.
     */
    public $paymentConfirmedEvent;

    /**
     * @var Event Raised when a payment confirmation fails.
     */
    public $paymentFailedEvent;

    /**
     * PaymentCaptureControl constructor.
     * @param null $name
     * @param bool $onSession True if the journey being developed is expected to be driven by the customer.
     * @param string $mode
     * @param callable|null $initialiseModelBeforeView
     * @throws \Rhubarb\Leaf\Exceptions\InvalidLeafModelException
     */
    public function __construct($name = null, $onSession = true, callable $initialiseModelBeforeView = null)
    {
        parent::__construct($name, function() use ($initialiseModelBeforeView, $onSession){
            if ($initialiseModelBeforeView){
                $initialiseModelBeforeView();
            }
            $this->model->onSession = $onSession;
        });

        $this->paymentConfirmedEvent = new Event();
        $this->paymentFailedEvent = new Event();
    }


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

        $this->model->confirmPaymentEvent->attachHandler(function($paymentEntity){
            $castPaymentEntity = PaymentEntity::castFromObject($paymentEntity);
            return $this->confirmPayment($castPaymentEntity);
        });
    }

    protected function confirmPayment(PaymentEntity $paymentEntity):  PaymentEntity
    {
        $service = $this->getProviderService();

        // Make sure that onSession is set correctly.
        $paymentEntity->onSession = $this->model->onSession;

        // Create the use case:
        ConfirmPaymentUseCase::create($service)->execute($paymentEntity);

        if ($paymentEntity->status == PaymentEntity::STATUS_SUCCESS){
            $this->paymentConfirmedEvent->raise($paymentEntity);
        }

        if ($paymentEntity->status == PaymentEntity::STATUS_FAILED){
            $this->paymentFailedEvent->raise($paymentEntity);
        }

        return $paymentEntity;
    }

    protected abstract function getProviderService();
}