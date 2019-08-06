<?php

namespace Gcd\Scaffold\Payments\Logic\Models;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\ModelSchema;

class PaymentCard extends Model
{
    protected function createSchema()
    {
        $schema = new ModelSchema('tblPaymentCard');

        $schema->addColumn(
            new AutoIncrementColumn('PaymentCardID')
        );

        return $schema;
    }
}
