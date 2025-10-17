<?php

use Phalcon\Db\Column;
use Phalcon\Db\Exception;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class ClientAddressesMigration_101
 */
class ClientAddressesMigration_101 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     * @throws Exception
     */
    public function morph(): void
    {
        $this->morphTable('client_addresses', [
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
                    'label',
                    [
                        'type' => Column::TYPE_ENUM,
                        'notNull' => true,
                        'size' => "'delivery','billing'",
                        'after' => 'client_id'
                    ]
                ),
                new Column(
                    'street',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 150,
                        'after' => 'label'
                    ]
                ),
                new Column(
                    'number',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 20,
                        'after' => 'street'
                    ]
                ),
                new Column(
                    'neighborhood',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 100,
                        'after' => 'number'
                    ]
                ),
                new Column(
                    'city',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 100,
                        'after' => 'neighborhood'
                    ]
                ),
                new Column(
                    'state',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 50,
                        'after' => 'city'
                    ]
                ),
                new Column(
                    'zip',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => false,
                        'size' => 20,
                        'after' => 'state'
                    ]
                ),
                new Column(
                    'country',
                    [
                        'type' => Column::TYPE_VARCHAR,
                        'default' => "Brazil",
                        'notNull' => false,
                        'size' => 50,
                        'after' => 'zip'
                    ]
                ),
                new Column(
                    'created_at',
                    [
                        'type' => Column::TYPE_TIMESTAMP,
                        'default' => "CURRENT_TIMESTAMP",
                        'notNull' => false,
                        'after' => 'country'
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
                new Index('unique_client_label', ['client_id', 'label'], 'UNIQUE'),
            ],
            'references' => [
                new Reference(
                    'client_addresses_ibfk_1',
                    [
                        'referencedSchema' => 'inventory',
                        'referencedTable' => 'clients',
                        'columns' => ['client_id'],
                        'referencedColumns' => ['id'],
                        'onUpdate' => 'NO ACTION',
                        'onDelete' => 'CASCADE'
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
