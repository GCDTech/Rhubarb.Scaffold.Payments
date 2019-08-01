<?php

namespace Gcd\Scaffold\Payments\UI\PaymentCaptureControl;

use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;
use Rhubarb\Leaf\Views\View;

class PaymentCaptureControlView extends View
{
    /**
     * @var PaymentCaptureControlModel
     */
    protected $model;

    public function getDeploymentPackage()
    {
        return new LeafDeploymentPackage(__DIR__.'/PaymentCaptureControlViewBridge.js');
    }

    protected function getViewBridgeName()
    {
        return "PaymentCaptureControlViewBridge";
    }

    protected function printViewContent()
    {

        ?>
        <p>Extend PaymentCaptureControlView to provide the card capture UI.</p>
        <?php
    }


}