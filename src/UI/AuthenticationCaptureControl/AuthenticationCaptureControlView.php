<?php

namespace Gcd\Scaffold\Payments\UI\AuthenticationCaptureControl;

use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class AuthenticationCaptureControlView extends View
{
    /** @var AuthenticationCaptureControlModel $model **/
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
        return new LeafDeploymentPackage(__DIR__ . '/AuthenticationCaptureControlViewBridge.js');
    }

    protected function getViewBridgeName()
    {
        return 'AuthenticationCaptureControlViewBridge';
    }
}
