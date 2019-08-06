<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Rhubarb\Leaf\Leaves\Leaf;

class PaymentFollowup extends Leaf
{
    /** @var PaymentFollowupModel $model **/
    protected $model;

    /**
     * @var PaymentTracking|null
     */
    private $paymentTracking;

    public function __construct(?PaymentTracking $paymentTracking = null)
    {
        $this->paymentTracking = $paymentTracking;

        parent::__construct("", function(){

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
