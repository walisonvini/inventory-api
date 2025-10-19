<?php

namespace App\Validators\Orders;

use App\Validators\BaseValidator;

use Phalcon\Filter\Validation\Validator\InclusionIn;

use Phalcon\Messages\Message;

use App\Models\Orders;

class UpdateOrderStatusValidator extends BaseValidator
{
    public function initialize()
    {
        $this->add(
            'shipping_status',
            new InclusionIn([
                'domain' => ['pending', 'checkout', 'in_transit', 'delivered', 'returned', 'cancelled'],
                'message' => 'Shipping status must be one of: pending, checkout, in_transit, delivered, returned, cancelled',
            ])
        );
    }
}
