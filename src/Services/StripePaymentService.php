<?php

namespace Gcd\Scaffold\Payments\Services;

class StripePaymentService implements PaymentServiceInterface
{
     public function startPayment($APIKey, PaymentServiceEntity $entity) : PaymentServiceEntity
     {
         Stripe::setApiKey($APIKey);

         $stripeParams = [
             'description' => $entity->description,
             'amount' => $entity->amount * 100,
             'currency' => $entity->currency,
             'confirmation_method' => 'manual',
             'confirm' => true,
         ];

         // Throw an exception if the customerID && cardID isn't supplied OR paymentToken isn't supplied

         if ($entity->providerIdentifierType == 'Card') {
             $card = Card::retrieve($entity->providerIdentifier);
             $customer = Customer::retrieve($card->Customer->Id);

             // We want to create the payment intent based on the stored card details
             $stripeParams['customer'] = $customer->Id;
             $stripeParams['payment_method'] = $card->Id;
         } else {
             // Just charge the card, don't remember it
             $stripeParams['payment_method_data'] = [ // Change this so we always create a card/customer on Stripe
                 'type' => 'card',
                 'card' => ['token' => $entity->providerIdentifier],
             ];
         }
         $stripeIntent = PaymentIntent::create($stripeParams);

         // Populate our PaymentServiceEntity

         // Call use case to save payment tracking information for creation

         return $entity;
     }
}