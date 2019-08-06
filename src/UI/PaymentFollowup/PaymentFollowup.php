<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Rhubarb\Leaf\Leaves\Leaf;

class PaymentFollowup extends Leaf
{
    /** @var PaymentFollowupModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return PaymentFollowupView::class;
    }

    protected function createModel()
    {
        return new PaymentFollowupModel();
    }
}
