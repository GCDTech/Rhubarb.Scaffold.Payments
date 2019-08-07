<?php

namespace Gcd\Scaffold\Payments;

use Gcd\Scaffold\Payments\Logic\Models\PaymentTracking;
use Gcd\Scaffold\Payments\UI\AuthenticationCaptureControl\AuthenticationCaptureControl;
use Gcd\Scaffold\Payments\UI\PaymentFollowup\PaymentFollowup;
use Rhubarb\Crown\DependencyInjection\Container;
use Rhubarb\Crown\Module;
use Rhubarb\Crown\UrlHandlers\GreedyUrlHandler;
use Rhubarb\Stem\Exceptions\RecordNotFoundException;

class PaymentsModule extends Module
{
    private static $authenticationControls = [];

    protected function registerUrlHandlers()
    {
        $this->addUrlHandlers([
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

    /**
     * Registers a UI control to handle authentication.
     *
     * This is only used as out-of-the-box behaviour in the payment follow up view.
     *
     * @param $paymentServiceAlias
     * @param $leafControlClass
     */
    public static function registerAuthenticationControl($paymentServiceAlias, $leafControlClass)
    {
        self::$authenticationControls[$paymentServiceAlias] = $leafControlClass;
    }

    /**
     * @param $paymentServiceAlias
     * @param string $controlName   The name the control will have on the view.
     * @return AuthenticationCaptureControl
     */
    public static function getAuthenticationControlForService($paymentServiceAlias, $controlName = "Authentication"): AuthenticationCaptureControl
    {
        if (isset(self::$authenticationControls[$paymentServiceAlias])){
            return Container::instance(self::$authenticationControls[$paymentServiceAlias], $controlName);
        }

        throw new \InvalidArgumentException($paymentServiceAlias." does not have a registered authentication capture control");
    }
}