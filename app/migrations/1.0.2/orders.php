<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrdersMigration_102
 */
class OrdersMigration_102 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('orders', [
            'columns' => [
                new Column(
                    'id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 1,
                        'first' => true
                    ]
                ),
                new Column(
                    'client_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'id'
                    ]
                ),
                new Column(
                    'address_id',
                    [
                        'type' => Column::TYPE_BIGINTEGER,
                        'unsigned' => true,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'client_id'
                    ]
                ),
                new Column(
                    'order_code',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 50,
                        'after' => 'address_id'
                    ]
                ),
                new Column(
                    'carrier',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 100,
                        'after' => 'order_code'
                    ]
                ),
                new Column(
                    'tracking_code',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 100,
                        'after' => 'carrier'
                    ]
                ),
                new Column(
                    'shipping_status',
                    [
                        'type' => Column::TYPE_ENUM,
                        'default' => "pending",
                        'notNull' => false,
                        'size' => "'pending','checkout','in_transit','delivered','returned','cancelled'",
                        'after' => 'tracking_code'
                    ]
                ),
                new Column(
                    'total_weight',
                    [
                        'type' => Column::TYPE_DECIMAL,
                        'notNull' => false,
                        'size' => 10,
                        'scale' => 2,
                        'after' => 'shipping_status'
                    ]
                ),
                new Column(
                    'total_volume',
                    [
                        'type' => Column::TYPE_DECIMAL,
                        'notNull' => false,
                        'size' => 10,
                        'scale' => 2,
                        'after' => 'total_weight'
                    ]
                ),
                new Column(
                    'notes',
                    [
                        'type' => Column::TYPE_TEXT,
                        'notNull' => false,
                        'after' => 'total_volume'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_TIMESTAMP,
                        'default' => "CURRENT_TIMESTAMP",
                        'notNull' => false,
                        'after' => 'notes'
                    ]
                ),
                new Column(
                    'updated_at',
                    [
                        'type' => Column::TYPE_TIMESTAMP,
                        'default' => "CURRENT_TIMESTAMP",
                        'notNull' => false,
                        'after' => 'created_at'
                    ]
                ),
            ],
            'indexes' => [
                new Index('PRIMARY', ['id'], 'PRIMARY'),
                new Index('order_code', ['order_code'], 'UNIQUE'),
                new Index('client_id', ['client_id'], ''),
                new Index('address_id', ['address_id'], ''),
            ],
            'references' => [
                new Reference(
                    'orders_ibfk_1',
                    [
                        'referencedSchema' => 'inventory',
                        'referencedTable' => 'clients',
                        'columns' => ['client_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'NO ACTION',
                        'onDelete' => 'NO ACTION'
                    ]
                ),
                new Reference(
                    'orders_ibfk_2',
                    [
                        'referencedSchema' => 'inventory',
                        'referencedTable' => 'client_addresses',
                        'columns' => ['address_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'NO ACTION',
                        'onDelete' => 'NO ACTION'
                    ]
                ),
            ],
            'options' => [
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '1',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'utf8mb4_0900_ai_ci',
            ],
        ]);
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up(): void
    {
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down(): void
    {
    }
}
