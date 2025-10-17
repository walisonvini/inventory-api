<?php

declare(strict_types=1);

namespace App\Models;

class ClientAddresses extends \Phalcon\Mvc\Model
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
     * @var string
     */
    public $label;

    /**
     *
     * @var string
     */
    public $street;

    /**
     *
     * @var string
     */
    public $number;

    /**
     *
     * @var string
     */
    public $neighborhood;

    /**
     *
     * @var string
     */
    public $city;

    /**
     *
     * @var string
     */
    public $state;

    /**
     *
     * @var string
     */
    public $zip;

    /**
     *
     * @var string
     */
    public $country;

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
        $this->setSource("client_addresses");
        
        $this->belongsTo(
            'client_id',
            \App\Models\Clients::class,
            'id',
            ['alias' => 'client']
        );
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientAddresses[]|ClientAddresses|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return ClientAddresses|\Phalcon\Mvc\Model\ResultInterface|\Phalcon\Mvc\ModelInterface|null
     */
    public static function findFirst($parameters = null): ?\Phalcon\Mvc\ModelInterface
    {
        return parent::findFirst($parameters);
    }

}
