<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class PaymentFollowupView extends View
{
    /** @var PaymentFollowupModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        parent::createSubLeaves();
    }

    protected function printViewContent()
    {
    }

    public function getDeploymentPackage()
    {
        return new LeafDeploymentPackage(__DIR__ . '/PaymentFollowupViewBridge.js');
    }

    protected function getViewBridgeName()
    {
        return 'PaymentFollowupViewBridge';
    }
}
