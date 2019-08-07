<?php

namespace Gcd\Scaffold\Payments\UI\PaymentFollowup;

use Gcd\Scaffold\Payments\PaymentsModule;
use Gcd\Scaffold\Payments\UI\AuthenticationCaptureControl\AuthenticationCaptureControl;
use Rhubarb\Leaf\Views\View;
use Rhubarb\Leaf\Leaves\LeafDeploymentPackage;

class PaymentFollowupView extends View
{
    /** @var PaymentFollowupModel $model **/
    protected $model;

    protected function createSubLeaves()
    {
        parent::createSubLeaves();

        $this->registerSubLeaf(
            $this->getAuthenticationControl()
        );
    }

    protected function printInvalidPayment()
    {
        ?><p class="error">Sorry, that payment wasn't recognised.</p><?php
    }


    /**
     * Returns the correct UI control for capturing customer authentication.
     *
     * By default this looks for the correct control registered using the
     * PaymentModule::registerAuthenticationControl() method, however for
     * more control you can extend this view and override this method.
     *
     * @return AuthenticationCaptureControl
     */
    protected function getAuthenticationControl(): AuthenticationCaptureControl
    {
        return PaymentsModule::getAuthenticationControlForService($this->model->paymentEntity->provider);
    }

    protected function printViewContent()
    {
        if (!$this->model->paymentEntity){
            $this->printInvalidPayment();
            return;
        }

        ?>
        <div class="js-authenticate">
            <h1>Continue your payment</h1>

            <p>A payment authorisation was declined by your bank as they have requested you provide
            authentication in order to authorise the payment.</p>

            <table>
                <tr>
                    <td>Amount</td>
                    <td><?=$this->model->paymentEntity->amount;?></td>
                </tr>
                <tr>
                    <td>Card</td>
                    <td><?=str_pad($this->model->paymentEntity->cardLastFourDigits, 16, '*',STR_PAD_LEFT);?></td>
                </tr>
                <tr>
                    <td>Expiry</td>
                    <td><?=$this->model->paymentEntity->cardExpiry;?></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button class="js-continue">Continue and Authenticate</button></td>
                </tr>
            </table>
        </div>
        <div class="js-success" style="display:none;">
            <h1>Success</h1>
            <p>Thank you, your payment has been authorised.</p>
        </div>
        <div class="js-failed" style="display:none;">
            <h1>Failure</h1>
            <p>Sorry, we were unable to get an authorisation for your payment.</p>
        </div>
        <?php

        print $this->leaves["Authentication"];
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
