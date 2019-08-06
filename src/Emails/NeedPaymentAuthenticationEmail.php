<?php

namespace Gcd\Scaffold\Payments\Emails;

use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\Sendables\Email\Email;

class NeedPaymentAuthenticationEmail extends Email
{
    /**
     * @var PaymentEntity
     */
    private $paymentEntity;

    public function __construct(PaymentEntity $paymentEntity)
    {
        $this->paymentEntity = $paymentEntity;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return "A payment requires your authentication.";
    }

    /**
     * @return string
     */
    public function getHtml()
    {
        ?>
        <p></p>
        <?php
    }

    /**
     * Sendable types must be able to return a text representation of it's message body.
     *
     * This is used by sending frameworks to store and index outgoing communications.
     *
     * @return string
     */
    public function getText()
    {
        // TODO: Implement getText() method.
    }

    /**
     * Expresses the sendable as an array allowing it to be serialised, stored and recovered later.
     *
     * @return array
     */
    public function toArray()
    {
        // TODO: Implement toArray() method.
    }
}