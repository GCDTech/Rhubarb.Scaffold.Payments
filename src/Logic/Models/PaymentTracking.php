<?php

namespace Gcd\Scaffold\Payments\Logic\Models;

use Gcd\Scaffold\Payments\Logic\Entities\ModelEntityMapping;
use Gcd\Scaffold\Payments\UI\Entities\PaymentEntity;
use Rhubarb\Crown\DateTime\RhubarbDateTime;
use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlEnumColumn;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlMediumTextColumn;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\MoneyColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
use Rhubarb\Stem\Schema\Columns\UUIDColumn;
use Rhubarb\Stem\Schema\ModelSchema;

class PaymentTracking extends Model
{
    use ModelEntityMapping;

    const STATUS_CREATED = 'Created';
    const STATUS_PENDING = 'Pending';
    const STATUS_AWAITING_SCA = 'Awaiting Authentication';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAILED = 'Failed';

    const TYPE_TOKEN = "Token";
    const TYPE_CARD = "Card";
    const TYPE_CUSTOMER = "Customer";
    
    protected function createSchema()
    {
        $schema = new ModelSchema("tblPaymentTracking");

        $schema->addColumn(
            new UUIDColumn("PaymentTrackingID"),
            new StringColumn("Provider", 50),
            new StringColumn("Description", 250),
            new StringColumn("ProviderIdentifier", 150),
            new StringColumn("ProviderPaymentMethodIdentifier", 150),
            new StringColumn("ProviderPaymentMethodType", 50),
            new StringColumn("EmailAddress", 150),
            new MySqlEnumColumn("Status", self::STATUS_CREATED, 
                [self::STATUS_CREATED, self::STATUS_AWAITING_SCA, self::STATUS_SUCCESS, self::STATUS_FAILED]),
            new MoneyColumn("Amount"),
            new StringColumn("Currency", 3),
            new StringColumn("CardType", 50),
            new StringColumn("CardLastFourDigits", 4),
            new StringColumn("CardExpiry", 10),
            new StringColumn("FailureMessage", 250),
            new DateTimeColumn("CreationDate"),
            new DateTimeColumn("LastUpdatedDate")
        );

        $schema->labelColumnName = "FullName";

        return $schema;
    }

    protected function beforeSave()
    {
        parent::beforeSave();

        if ($this->isNewRecord())
        {
            $this->CreationDate = new RhubarbDateTime('now');
        }

        $this->LastUpdatedDate = new RhubarbDateTime('now');
    }


    public static function fromEntity(PaymentEntity $entity): PaymentTracking
    {
        $paymentTracking = new PaymentTracking();
        $paymentTracking->setModelFromEntity($entity);
        return $paymentTracking;
    }

    public function toEntity(): PaymentEntity
    {
        $entity = new PaymentEntity();

        $this->setEntityFromModel($entity);

        return $entity;
    }

    protected function getEntityModelPropertyMap(): array
    {
        return [
            "provider" => "Provider",
            "description" => "Description",
            "providerIdentifier" => "ProviderIdentifier",
            "providerPublicIdentifier" => "PublicIdentifier",
            "providerPaymentMethodIdentifier" => "ProviderPaymentMethodIdentifier",
            "providerPaymentMethodType" => "ProviderPaymentMethodType",
            "emailAddress" => "EmailAddress",
            "status" => "Status",
            "amount" => "Amount",
            "currency" => "Currency",
            "cardType" => "CardType",
            "cardLastFourDigits" => "CardLastFourDigits",
            "cardExpiry" => "CardExpiry",
            "error" => "FailureMessage",
        ];
    }
}