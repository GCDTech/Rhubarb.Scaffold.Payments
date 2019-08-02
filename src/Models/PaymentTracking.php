<?php

namespace Gcd\Scaffold\Payments\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlEnumColumn;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlMediumTextColumn;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\MoneyColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
use Rhubarb\Stem\Schema\ModelSchema;

class PaymentTracking extends Model
{
    const STATUS_CREATED = 'Created';
    const STATUS_PENDING = 'Pending';
    const STATUS_AWAITING_SCA = 'Awaiting Authentication';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAILED = 'Failed';
    
    protected function createSchema()
    {
        $schema = new ModelSchema("tblPaymentTracking");

        $schema->addColumn(
            new AutoIncrementColumn("PaymentTrackingID"),
            new StringColumn("PaymentService", 50),
            new StringColumn("PaymentDescription", 250),
            new StringColumn("EmailAddress", 150),
            new MySqlEnumColumn("Status", self::STATUS_CREATED, 
                [self::STATUS_CREATED, self::STATUS_AWAITING_SCA, self::STATUS_SUCCESS, self::STATUS_FAILED]),
            new MoneyColumn("Amount"),
            new StringColumn("Currency", 3),
            new StringColumn("CardType", 50),
            new StringColumn("CardLastFourDigits", 4),
            new StringColumn("CardExpiry", 10),
            new DateTimeColumn("CreationDate"),
            new DateTimeColumn("LastUpdatedDate"),
            new MySqlMediumTextColumn("AdditionalData")
        );

        $schema->labelColumnName = "FullName";

        return $schema;
    }
}