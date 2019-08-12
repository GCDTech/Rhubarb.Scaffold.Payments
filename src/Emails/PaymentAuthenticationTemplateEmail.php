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
         <h1>Authentication Required</h1>
         <p>Awaiting Payment for card ending in {$this->paymentEntity->cardLastFourDigits}</p>
         <p>Amount: {$this->paymentEntity->amount} {$this->paymentEntity->currency}</p>
         <a href="$link" target="_blank">Authenticate Now</a>
               
HTML;
    }
}