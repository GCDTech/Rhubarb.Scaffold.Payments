<?php

namespace Gcd\Scaffold\Payments;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\UI\PaymentFollowup\PaymentFollowup;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\GreedyUrlHandler;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;

class PaymentsModule extends Module
{
    protected function addUrlHandlers()
    {
        parent::addUrlHandlers([
            "/payments/" => new GreedyUrlHandler(function($paymentId = null){

                try {
                    $payment = new PaymentTracking($paymentId);
                    return new PaymentFollowup($payment);
                } catch (RecordNotFoundException $er){
                    return new PaymentFollowup();
                }

            }, [], "([^/]*)(/|$)")
        ]);
    }
}