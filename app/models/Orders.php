<?php
declare(strict_types=1);

namespace App\Models;

class Orders extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $client_id;

    /**
     *
     * @var integer
     */
    public $address_id;

    /**
     *
     * @var string
     */
    public $order_code;

    /**
     *
     * @var string
     */
    public $carrier;

    /**
     *
     * @var string
     */
    public $tracking_code;

    /**
     *
     * @var string
     */
    public $shipping_status;

    /**
     *
     * @var double
     */
    public $total_weight;

    /**
     *
     * @var double
     */
    public $total_volume;

    /**
     *
     * @var string
     */
    public $notes;

    /**
     *
     * @var string
     */
    public $created_at;

    /**
     *
     * @var string
     */
    public $updated_at;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("inventory");
        $this->setSource("orders");

        $this->belongsTo(
            'client_id', 
            \App\Models\Clients::class, 
            'id', 
            ['alias' => 'client']
        );

        $this->belongsTo(
            'address_id', 
            ClientAddresses::class,
            'id', 
            ['alias' => 'address']
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orders[]|Orders|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Orders|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
