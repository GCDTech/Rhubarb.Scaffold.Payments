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
        <div class="o-wrap u-pos-rel" style="height:100vh;">
            <div class="u-fill-white u-pad--heavy u-rounded u-1/2@m u-pull-v-center u-shadow">
                <div class="js-authenticate">
                <?php print $this->printAuthenticateContent(); ?>
                </div>

                <div class="js-success" style="display:none;">
                <?php print $this->printSuccessContent(); ?>
                </div>

                <div class="js-failed" style="display:none;">
                <?php print $this->printFailedContent(); ?>
                </div>
            </div>
        </div>
        <?php print $this->leaves["Authentication"];
    }

    protected function printSuccessContent() {
        ?>
        <div class="u-align-center">
            <img src="../static/images/positive.svg" alt="" style="width:100px;">
            <h1 class="u-delta">Thank you</h1>
            <p class="u-lighten">Your payment has been authorised. <br />You can now close this window.</p>
        </div>
        <?php
    }

    protected function printFailedContent() {
        ?>
        <div class="u-align-center u-marg-bottom">
            <img src="../static/images/negative.svg" alt="" style="width:100px;">
            <h1 class="u-delta">Failure</h1>
            <p class="u-lighten">Sorry, we were unable to get an authorisation for your payment.</p>
        </div>
        <div class="u-fill-white u-pad u-rounded u-shadow u-bordered u-marg-bottom">
            <p class="u-bold">Possible reasons for failure</p>
            <ul class="u-list-bullets u-lighten">
                <li>3D Secure authorisation failure</li>
                <li>Insufficient funds in account</li>
                <li>Expired card</li>
            </ul>
        </div>
        <p class="u-lighten u-align-center">Alternatively, you can <a href="" class="u-secondary"><u>use another card</u></a> as a payment
            method</p>
        <?php
    }

    protected function printAuthenticateContent() {
        ?>
        <div class="o-layout u-marg-bottom">
            <div class="o-layout__item u-1/2@m u-marg-bottom">
                <h1 class="u-delta">Continue your payment</h1>
                <p class="u-marg-bottom u-lighten">A payment authorisation was declined by your bank as they have requested you provide
                    authentication in order to authorise the payment.</p>
            </div>
            <div class="o-layout__item u-1/2@m u-marg-bottom">
                <div class="u-border-light u-border-thick u-pad u-rounded u-shadow">
                    <div class="u-marg-bottom">
                        <label for="" class="u-uppercase u-milli u-lighten">Amount</label>
                        <div class="u-border-bottom u-beta u-tertiary"><?= $this->model->paymentEntity->amount; ?>
                            <?= $this->model->paymentEntity->currency; ?></div>
                    </div>
                    <div class="u-marg-bottom">
                        <label for="" class="u-uppercase u-milli u-lighten">Card</label>
                        <div class="u-border-bottom u-beta u-tertiary"><?= str_pad(
                                $this->model->paymentEntity->cardLastFourDigits,
                                16,
                                '*',
                                STR_PAD_LEFT
                            ); ?></div>
                    </div>
                    <div class="u-marg-bottom">
                        <label for="" class="u-uppercase u-milli u-lighten">Expiry</label>
                        <div class="u-border-bottom u-beta u-tertiary"><?= $this->model->paymentEntity->cardExpiry; ?></div>
                    </div>
                </div>
            </div>
        </div>
        <button class="js-continue c-button +secondary +large u-1 +processing">Continue and Authenticate</button>
        <?php
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
