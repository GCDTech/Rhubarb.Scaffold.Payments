<?php

namespace Gcd\Scaffold\Payments\Logic\UseCases;

use Gcd\Scaffold\Payments\Emails\PaymentAuthenticationTemplateEmail;
use Gcd\UseCases\UseCase;
use Rhubarb\Crown\Sendables\Email\EmailProvider;

class SendPaymentAuthorisationRequestEmailUseCase extends UseCase
{
    /** @var PaymentAuthenticationTemplateEmail $paymentAuthenticationTemplateEmail */
    private $paymentAuthenticationTemplateEmail;

    public function __construct(PaymentAuthenticationTemplateEmail $paymentAuthenticationTemplateEmail)
    {
        $this->paymentAuthenticationTemplateEmail = $paymentAuthenticationTemplateEmail;
    }
    
    public function execute($email) {
        $this->paymentAuthenticationTemplateEmail->addRecipientByEmail($email);
        EmailProvider::selectProviderAndSend($this->paymentAuthenticationTemplateEmail);
    }
}