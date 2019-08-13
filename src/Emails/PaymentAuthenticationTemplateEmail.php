<?php

namespace Gcd\Scaffold\Payments\Emails;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\Sendables\Email\Email;
use Rhubarb\Crown\Sendables\Email\TemplateEmail;

abstract class PaymentAuthenticationTemplateEmail extends TemplateEmail
{
    /**
     * @var PaymentEntity
     */
    private $paymentEntity;

    public function __construct(PaymentEntity $paymentEntity, array $recipientData = [])
    {
        parent::__construct($recipientData);
        $this->paymentEntity = $paymentEntity;
    }

    protected function getTextTemplateBody()
    {
        return strip_tags($this->getHtmlTemplateBody());
    }

    /**
     * @return string
     */
    protected function getSubjectTemplate()
    {
        return "A payment requires your authentication.";
    }

    protected abstract function getBaseUrl();

    protected function getContent()
    {
        $link = $this->getBaseUrl().'/payments/'.$this->paymentEntity->id;
        return <<<HTML
         <h1>Your bank needs you to authorise a payment</h1>
         <p>Before we can receive your payment, your bank needs you to give permission.</p>
         <p>{$this->paymentEntity->description} <br>
         {$this->paymentEntity->amount} {$this->paymentEntity->currency}</p>
         <a href="$link" target="_blank">Continue Payment</a>
         <p>New EU regulations require customers to authenticate all new payments. This is a new, more secure way to keep your cash safe when purchasing online.</p>
         <p>Read more about it here</p>
         <p>We will <b>NEVER</b> as for your card details or other financial information</p>               
HTML;
    }
}