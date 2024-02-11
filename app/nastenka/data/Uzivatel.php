<?php

namespace nastenka\data;

use nastenka\data\Listecky;
class Uzivatel extends \DB\Cortex
{
    protected $db = 'DB';
    protected $table = 'uzivatel';
    protected $primary = 'id';

    protected $fieldConf = [
        'jmeno' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'email' => [
            'type' => 'TEXT',
            'nullable' => false,
            'unique' => true,
        ],
        'heslo' => [
            'type' => 'VARCHAR256',
            'nullable' => false,
        ],
        'dokument'=> [
            'has-many' => ['\nastenka\data\Listecky','autor'],
        ],
    ];

    public function set_heslo($value) {
        return password_hash($value, PASSWORD_DEFAULT); //Password hash
    }
}