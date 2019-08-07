<?php

namespace Gcd\Scaffold\Payments\UI\AuthenticationCaptureControl;

use Rhubarb\Leaf\Leaves\Leaf;

class AuthenticationCaptureControl extends Leaf
{
    /** @var AuthenticationCaptureControlModel $model **/
    protected $model;

    protected function getViewClass()
    {
        return AuthenticationCaptureControlView::class;
    }

    protected function createModel()
    {
        return new AuthenticationCaptureControlModel();
    }
}
